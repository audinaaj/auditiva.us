<?php

$db = array_merge(
    require(__DIR__ . '/db.php'),
    require(__DIR__ . '/db-local.php')
);

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
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',  
            'defaultRoles'   => ['admin', 'manager', 'editor', 'author', 'poweruser', 'registered'],  // Default roles
            // By default, yii\rbac\PhpManager stores RBAC data in files under @app/rbac/ directory.
            // Make sure that directory is web writable.
            'itemFile'       => '@app/rbac/data/items.php',                // Default path to items.php
            'assignmentFile' => '@app/rbac/data/assignments.php',          // Default path to assignments.php
            'ruleFile'       => '@app/rbac/data/rules.php',                // Default path to rules.php
        ],
    ],
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

return $config;
