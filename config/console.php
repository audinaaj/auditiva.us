<?php

$params = require(__DIR__ . '/params.php');
$db =require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'transport' => [
                // 'scheme' => 'smtps',
                // 'require_tls' => true,
                // 'host'       => $params['mail.server'],
                // 'username'   => $params['mail.username'],
                // 'password'   => $params['mail.password'],
                // 'port' => 587,
                ////'dsn' => 'microsoftgraph+api://CLIENT_APP_ID:CLIENT_APP_SECRET@default?tenantId=TENANT_ID',
                'dsn' => 'smtp://'.$params['mail.username'].':'.$params['mail.password'].'@'.$params['mail.server'].':587',
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
    ],
    'container' => [
        'definitions' => [
            EsmtpTransportFactory::class => [
                'class' => Symfony\Component\Mailer\Bridge\MicrosoftGraph\Transport\MicrosoftGraphTransportFactory::class,
            ],
        ],
    ],
];

return $config;
