<?php
$params = require(__DIR__ . '/params.php');
$config = [
	'id'         => 'basic',
	'basePath'   => dirname(__DIR__),
	'language'   => 'ru',
	'bootstrap'  => ['log', 'gii', 'university'],
	'name'       => 'Электронное портфолио студента',
	//'defaultRoute'=>'/works',
	'components' => [
		'authManager'  => [
			'class'        => 'yii\rbac\PhpManager',
			'defaultRoles' => [
				'god',
				'student',
				'teacher',
				'admin',
			], // Здесь нет роли "guest", т.к. эта роль виртуальная и не присутствует в модели UserExt
		],
		'university'   => [
			'class' => 'app\components\University',
		],
		'assetManager' => [
			'converter' => [
				'forceConvert' => TRUE,
			]
		],
		/*'clientScript' => [

			// disable default yii scripts
			'scriptMap' => [
				'jquery.js'     => false,
				'jquery.min.js' => false,
			],
		],*/
		'request'      => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'qWAJRmarPcAvHIwgJun_QSkqwKSBeBZn',
		],
		'response'     => [
			'formatters' => [
				'pdf' => [
					'class'           => 'robregonm\pdf\PdfResponseFormatter',
					'mode'            => '', // Optional
					'format'          => 'A4',  // Optional but recommended. http://mpdf1.com/manual/index.php?tid=184
					'defaultFontSize' => 0, // Optional
					'defaultFont'     => '', // Optional
					'marginLeft'      => 5, // Optional
					'marginRight'     => 5, // Optional
					'marginTop'       => 5, // Optional
					'marginBottom'    => 5, // Optional
					'marginHeader'    => 3, // Optional
					'marginFooter'    => 3, // Optional
					'orientation'     => 'Portrait', // optional. This value will be ignored if format is a string value.
					'options'         => [
						// mPDF Variables
						// 'fontdata' => [
						// ... some fonts. http://mpdf1.com/manual/index.php?tid=454
						// ]
					],
				    'methods' => [
					    /*'setHTMLHeader' => 'asfasdf'*/
				    ]
				],
			]
		],
		'cache'        => [
			'class' => 'yii\caching\FileCache',
		],
		'import'       => [
			'class'      => 'app\components\Import',
			'hash'       => 'GVr9Z7vufM2c',
			'outputPath' => '@app/output',
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
			'class'             => 'app\components\ErrorHandler',
			'errorAction'       => 'site/error',
			'exceptionUserView' => '@app/views/errors/exceptionUser.php'
		],
		'mailer'       => [
			'class'     => 'yii\swiftmailer\Mailer',
			'transport' => [
				'class'      => 'Swift_SmtpTransport',
				'host'       => 'smtp.yandex.ru',
				'port'       => '465',
				'username'   => 'pochta@studentsonline.ru',
				'password'   => '0kujCZt5',
				'encryption' => 'ssl',
			],
		],
		/*'mailer'       => [
			'class' => 'yii\swiftmailer\Mailer',
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => '62.109.7.245',
				'port' => '587',
				'username' => 'postmaster@studentsonline.ru',
				'password' => 'eR2EFsBi',
				'encryption' => 'tls',
			],
		],*/
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				'file'  => [
					'class'   => 'yii\log\FileTarget',
					'levels'  => ['error', 'warning'],
					'logFile' => '@app/log/error.log'
				],
				'email' => [
					'class'   => 'app\components\EmailTargetTrue',
					'levels'  => ['error'/*, 'warning'*/],
					'message' => [
						'from' => ['pochta@studentsonline.ru'=>'StudentsOnline.ru: Робот'],
						'to'      => [/*'dostoevskiy.spb@gmail.com', */'dev@studentsonline.ru'],
						'subject' => 'Ошибка в работе сервиса',
					],
				],
			],
		],
		'urlManager'   => [
			'enablePrettyUrl'     => TRUE,
			'enableStrictParsing' => FALSE,
			'showScriptName'      => FALSE,
			'rules'               => [
				'http://studentsonline.ru'              => 'land/index',
				'http://www.studentsonline.ru'          => 'land/index',
				'http://u.studentsonline.ru'            => 'site/u',
				'http://studentsonline.ru/presentation' => 'land/presentation',
				'http://studentsonline.ru/success'      => 'land/success',
				//'http://studentsonline.ru/landing/create' => 'landing/create',
				//				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
				'debug/<controller>/<action>'           => 'debug/<controller>/<action>',
				'<controller>/<action>'                 => '<controller>/<action>',
				'login'                                 => 'site/login',
				'login_as'                              => 'site/login_as',
			],
		],
		/*'session'      => [
			'class' => 'yii\mongodb\Session',
		],*/
		'db'           => require(__DIR__ . '/db.php'),
		//'mongodb'      => require(__DIR__ . '/mongodb.php'),
	],
	'params'     => $params,
];
if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][]                    = 'debug';
	$config['modules']['debug']               = [
		'class'      => 'yii\debug\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '176.117.143.48', '192.168.56.112', '217.71.236.162', '217.71.236.160', '217.71.236.160'],
		'panels'     => [
			'university' => ['class' => 'app\panels\UniversityPanel'],
			'mongodb'    => [
				'class' => 'yii\\mongodb\\debug\\MongoDbPanel',
			],
		],
	];
	$config['bootstrap'][]                    = 'gii';
	$config['modules']['gii']                 = [
		'class'      => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '176.117.143.48', '192.168.56.112', '217.71.236.162', '217.71.236.160'],
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
