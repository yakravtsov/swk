<?php

return [
	'class' => 'yii\db\Connection',
	'dsn' => 'pgsql:host=62.109.7.245;dbname=students',
	'username' => 'pgsql',
	'password' => '0000',
	'charset' => 'utf8',
	'enableSchemaCache'=>false,
	'schemaCacheDuration'=> YII_DEBUG ? 0 : 3600,
//	'schemaCacheExclude' => ['user'],
	'emulatePrepare' => false,
	'schemaMap' => [
		'pgsql'=> [
			'class'=>'yii\db\pgsql\Schema',
			'defaultSchema' => 'public', //specify your schema here
		]
	],
];