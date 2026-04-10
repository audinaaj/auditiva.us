<?php

$params = require(__DIR__ . '/params.php');
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
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
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
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'transport' => [
                // 'scheme' => 'smtps',
                // 'require_tls' => true,
                // 'host'       => 'smtp.office365.com',
                // 'username'   => $params['mail.username'],
                // 'password'   => $params['mail.password'],
                // 'port' => 587,
                'dsn' => 'smtp://'.$params['mail.username'].':'.$params['mail.password'].'@smtp.office365.com:587',
                //'dsn' => 'microsoftgraph+api://CLIENT_APP_ID:CLIENT_APP_SECRET@default?tenantId=TENANT_ID',
                //'dsn' => 'microsoftgraph+api://'.$params['mail.clientId'].':'.$params['mail.clientSecret'].'@default?tenantId='.$params['mail.tenantId'],
            ],

            // Directory that contains the view files 
            // for composing mail messages. Defaults to '@app/mail'
            'viewPath' => '@app/mail',

            // Send all mail messages to a file by default. 
            // The messages get stored locally under '@app/runtime/mail'
            'useFileTransport' => false,
            //'fileTransportPath' => '@runtime/mail',
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
                'GET api/backup-database' => 'site/backup-database',
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'formatter' => [
           'class'           => 'app\components\CdnFormatter',
           'dateFormat'      => 'php:M d, Y',
           'datetimeFormat'  => 'php:M d, Y H:i:s',
           'timeFormat'      => 'php:H:i:s', 
           'defaultTimeZone' => 'America/New_York'
        ],
        'reCaptcha' => [
            'name'    => 'reCaptcha',
            'class'   => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => $params['recaptchaSiteKeyv2'],
            'secret'  => $params['recaptchaSecretv2'],
        ],
        's3' => [
            'class' => 'bpsys\yii2\aws\s3\Service',
            'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
                'key' => $params['s3.key'],
                'secret' => $params['s3.secret'],
            ],
            'region' => 'us-east-1',
            'defaultBucket' => 'auditiva',
            'defaultAcl' => 'public-read',
            'defaultPresignedExpiration' => '+1 hour',
            'endpoint' => 'https://nyc3.digitaloceanspaces.com',
        ],
    ],
    'modules' => [
        's3manager' => [
            'class' => 'skylineos\yii\s3manager\Module',
            // All settings can be configured on the fly regardless of usage type (fileinput, standalone manager, tinymce plugin)
            'configuration' => [ 
                'bucket'   => 'auditiva',
                'version'  => 'latest',
                'region'   => 'us-east-1',
                'prefix'   => '',
                'scheme'   => 'http',
                'endpoint' => 'https://nyc3.digitaloceanspaces.com',
                'credentials' => [
                    'key'    => $params['s3.key'],
                    'secret' => $params['s3.secret'],
                ],
            ]
        ],
    ],
    'container' => [
        'definitions' => [
            EsmtpTransportFactory::class => [
                'class' => Symfony\Component\Mailer\Bridge\MicrosoftGraph\Transport\MicrosoftGraphTransportFactory::class,
            ]
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
        'allowedIPs' => $params['debug.allowedIPs'], // this doesn't work well with docker
        //'allowedIPs' => ['*'], // allow all IPs to access debug module, since we are using docker and IPs can be dynamic
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
