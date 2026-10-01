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
                'dsn' => 'microsoftgraph+api://'.$params['mail.clientId'].':'.$params['mail.clientSecret'].'@default?tenantId='.$params['mail.tenantId'],
            ],
            'viewPath' => '@app/mail',
            'useFileTransport' => false,
        ],
    ],
    'params' => $params,
];

return $config;
