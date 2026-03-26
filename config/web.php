<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
 
$db =require(__DIR__ . '/db.php');

// Set current location to be root directory, i.e. '/web' becomes '/'
// Mod_Rewrite procedure will send traffic to '/' if files are in '/var/www/html'
$baseUrl = str_replace('/web', '', (new \yii\web\Request)->getBaseUrl());

$config = [
    'id' => 'basic',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => $params['cookieKey'] . $params['appId'],
            
            // Required if wanting to hide 'web' folder from url
            'baseUrl' => $baseUrl,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name' => $params['appId'] . '_User', // unique for app
            ],
        ],
        'session' => [
            'name'     => $params['appId'] . '_SessionId', // unique for app
            //'savePath' => __DIR__ . '/../runtime', // a temporary folder for app
            'class' => 'yii\web\DbSession',
            'GCProbability' => 1, // 1% chance of garbage collection
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'emailService' => [
            'class' => 'app\components\EmailMicroservice',
            'baseUrl' => $params['mail.apiAddress'],
            'apiKey' => $params['mail.apikey'],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',

            // Directory that contains the view files 
            // for composing mail messages. Defaults to '@app/mail'
            'viewPath' => '@app/mail',

            // Send all mail messages to a file by default. 
            // The messages get stored locally under '@app/runtime/mail'
            //'useFileTransport' => true,
            //'fileTransportPath' => '@runtime/mail',

            // Send all mail messages as real emails.
            // Set 'useFileTransport' to false,
            // and configure a transport for the mailer.
            'useFileTransport' => false,
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.office365.com',
                'username'   => $params['mail.username'],
                'password'   => $params['mail.password'],
                'port'       => '587',
                'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'baseUrl'         => $baseUrl,  // Required if wanting to hide 'web' folder from url
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            //'linkAssets' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',  
            'defaultRoles'   => ['admin', 'manager', 'editor', 'author', 'poweruser', 'registered'],  // Default roles
            // By default, yii\rbac\PhpManager stores RBAC data in files under @app/rbac/ directory.
            // Make sure that directory is web writable.
            'itemFile'       => '@app/rbac/data/items.php',                // Default path to items.php
            'assignmentFile' => '@app/rbac/data/assignments.php',          // Default path to assignments.php
            'ruleFile'       => '@app/rbac/data/rules.php',                // Default path to rules.php
        ],
        'formatter' => [
           'class'           => 'yii\i18n\Formatter',
           'dateFormat'      => 'php:M d, Y',
           'datetimeFormat'  => 'php:M d, Y H:i:s',
           'timeFormat'      => 'php:H:i:s', 
           'defaultTimeZone' => 'America/New_York'
        ],
        // Yii2 TCPDF
        'tcpdf' => [
            'class' => 'cinghie\tcpdf\TCPDF',
        ],
        'reCaptcha' => [
            'name'    => 'reCaptcha',
            'class'   => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => $params['recaptchaSiteKeyv2'],
            'secret'  => $params['recaptchaSecretv2'],
        ],
    ],
    'params' => $params,
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'enableDebugLogs' => true,
        //'allowedIPs' => $params['debug.allowedIPs'], // this doesn't work well with docker
        'allowedIPs' => ['*'], // allow all IPs to access debug module, since we are using docker and IPs can be dynamic
    ];

    // $config['bootstrap'][] = 'gii';
    // $config['modules']['gii'] = [
    //     'class' => 'yii\gii\Module',
    //     // uncomment the following to add your IP if you are not connecting from localhost.
    //     //'allowedIPs' => ['127.0.0.1', '::1'],
    //     'allowedIPs' => $params['debug.allowedIPs'],
    // ];
}

return $config;
