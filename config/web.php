<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	'language' => 'ru-RU',
	'bootstrap' => ['log', 'gii'],
	//'defaultRoute'=>'/works',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qWAJRmarPcAvHIwgJun_QSkqwKSBeBZn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
			'loginUrl'=>'/login'
		],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => false,
			'showScriptName' => false,
			'rules' => [
				//				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
				'debug/<controller>/<action>' => 'debug/<controller>/<action>',
				'<controller>/<action>' => '<controller>/<action>',
				'login' => 'site/login'
			],
		],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] =  [
		'class' => 'yii\debug\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '176.117.143.48', '192.168.56.112']
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '176.117.143.48', '192.168.56.112', '217.71.236.162'],
	];

	$config['components']['log']['targets'][] = [
		'class' => 'yii\log\FileTarget',
		'levels' => ['info'],
		'categories' => ['apiRequest'],
		'logFile' => '@app/log/requests.log',
		'maxFileSize' => 1024 * 2,
		'maxLogFiles' => 20,
	];
	$config['components']['log']['targets'][] = [
		'class' => 'yii\log\FileTarget',
		'levels' => ['info'],
		'categories' => ['apiResponse'],
		'logFile' => '@app/log/response.log',
		'maxFileSize' => 1024 * 2,
		'maxLogFiles' => 20,
	];
}
return $config;
