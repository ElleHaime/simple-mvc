<?php

$config = [
	'database' => [
		'adapter' => 'mysql',
		'host' => 'localhost',
		'port' => 3306,
		'user' => 'root',
		'password' => 'root',
		'dbname' => 'beejee'
	],

	'template' => [
		'viewMode' => 'html',
		'compiledPath' => '/var/www/BeeJee/var/compiled/',	
		'cssPath' => '/css/',
		'jsPath' => '/js/',
	],

	'logs' => [
		'logPath' => '/var/www/BeeJee/var/logs/log.txt'
	],

	'images' => [
		'maxWidth' => '320px'.
		'maxHeight' => '240px';
		'uploadPath' => '/var/www/BeeJee/public/upload/',
		'imgExt' = ['jpg', 'png']
	]
];
