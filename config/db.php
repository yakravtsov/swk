<?php

return [
	'class' => 'yii\db\Connection',
	'dsn' => 'pgsql:host=localhost;dbname=students',
	'username' => 'postgres',
	'password' => 'sGXUXZLH9s',
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
