<?php

error_reporting(E_ALL & ~E_NOTICE);

if (!defined('DIR_SEP')) {
	define('DIR_SEP', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT_PROJECT')) {
	define('ROOT_PROJECT', dirname(dirname(__FILE__)) . DIR_SEP);
}
if (!defined('ROOT_APP')) {
	define('ROOT_APP', ROOT_PROJECT . 'app' . DIR_SEP);
}
if (!defined('ROOT_LIB')) {
	define('ROOT_LIB', ROOT_APP . 'lib' . DIR_SEP);
}
if (!defined('CONFIG_PATH')) {
	define('CONFIG_PATH', ROOT_PROJECT . 'config' . DIR_SEP . 'config.php');
}

require_once(ROOT_APP . 'autoload.php');

try {
	$app = new Lib\Bootstrap();
	$app -> run();
	echo $app -> output();

} catch (\Exception $e) {
	// find somewhere logger and write something
	throw $e;
} 

