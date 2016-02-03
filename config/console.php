<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
Yii::setAlias('@importCsvOutput', dirname(__DIR__) . '/output');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'authManager'  => [
            'class'        => 'yii\rbac\PhpManager',
        ],
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
        'import'           => [
            'class'      => 'app\components\Import',
            'startRow'   => 0,
            'hash'       => 'GVr9Z7vufM2c',
            'outputPath' => '@importCsvOutput',
            'delimiter'  => ';',
            'columnsMap' => [
                'phio'       => 0,
                'number'     => 1,
                'start_year' => 2
            ],
        ],
        'db' => $db,
        'mongodb'          => require(__DIR__ . '/mongodb.php'),
    ],
    'params' => $params,
];
