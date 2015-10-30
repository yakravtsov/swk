<?php

$params = require(__DIR__ . '/params.php');
$config = [
	'id'         => 'basic',
	'basePath'   => dirname(__DIR__),
	'language'   => 'ru-RU',
	'bootstrap'  => ['log', 'gii'],
	//'defaultRoute'=>'/works',
	'components' => [
		'university' => [
			'class'=>'app\components\University',
		],
		// todo ������ �����
		'assetManager' => [
			'converter' => [
				'forceConvert' => true,
			]
		],
		'request'      => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'qWAJRmarPcAvHIwgJun_QSkqwKSBeBZn',
		],
		'cache'        => [
			'class' => 'yii\caching\FileCache',
		],
		'import'       => [
			'class'      => 'app\components\Import',
			'startRow'   => 0,
			'delimiter'  => ';',
			'columnsMap' => [
				'phio'       => 0,
				'number'     => 1,
				'start_year' => 2
			],
		],
		'user'         => [
			'class'           => 'app\components\User',
			'identityClass'   => 'app\models\User',
			'enableAutoLogin' => TRUE,
			'loginUrl'        => '/login'
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer'       => [
			'class'            => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => TRUE,
		],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				'file'  => [
					'class'  => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
					'logFile' => '@app/log/error.log'
				],
				'email' => [
					'class'   => 'yii\log\EmailTarget',
					'levels'  => ['error', 'warning'],
					'message' => [
						'to'      => ['dostoevskiy.spb@gmail.com', 'yakravtsov@gmail.com'],
						'subject' => 'SWK Error',
					],
				],
			],
		],
		'urlManager'   => [
			'enablePrettyUrl'     => TRUE,
			'enableStrictParsing' => FALSE,
			'showScriptName'      => FALSE,
			'rules'               => [
				'http://studentsonline.ru' => 'land/index',
				'http://www.studentsonline.ru' => 'land/index',
				//				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
//				'debug/<controller>/<action>' => 'debug/<controller>/<action>',
				'<controller>/<action>'       => '<controller>/<action>',
				'login'                       => 'site/login'
			],
		],
		'session' => [
			'class' => 'yii\mongodb\Session',
		],
		'db'           => require(__DIR__ . '/db.php'),
		'mongodb'           => require(__DIR__ . '/mongodb.php'),
		'on beforeRequest' => function ($event) {
				Yii::$app->university->init();
			},
	],
	'params'     => $params,
];
if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][]      = 'debug';
	$config['modules']['debug'] = [
		'class'      => 'yii\debug\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '176.117.143.48', '192.168.56.112'],
		'panels' => [
			'university' => ['class' => 'app\panels\UniversityPanel'],
			'mongodb' => [
				'class' => 'yii\\mongodb\\debug\\MongoDbPanel',
			],
		],
	];
	$config['bootstrap'][]    = 'gii';
	$config['modules']['gii'] = [
		'class'      => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '176.117.143.48', '192.168.56.112', '217.71.236.162'],
		'generators' => [
			'mongoDbModel' => [
				'class' => 'yii\mongodb\gii\model\Generator'
			]
		],
	];
	$config['components']['log']['targets'][] = [
		'class'       => 'yii\log\FileTarget',
		'levels'      => ['info'],
		'categories'  => ['apiRequest'],
		'logFile'     => '@app/log/requests.log',
		'maxFileSize' => 1024 * 2,
		'maxLogFiles' => 20,
	];
	$config['components']['log']['targets'][] = [
		'class'       => 'yii\log\FileTarget',
		'levels'      => ['info'],
		'categories'  => ['apiResponse'],
		'logFile'     => '@app/log/response.log',
		'maxFileSize' => 1024 * 2,
		'maxLogFiles' => 20,
	];
}
return $config;
