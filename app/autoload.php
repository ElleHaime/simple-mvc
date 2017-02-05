<?php

spl_autoload_register(function($className) {
	$filePath = ROOT_APP . str_replace('\\', DIR_SEP, $className). '.php';
    if(file_exists($filePath)) {
    	require_once($filePath);
    } else {
    	// redirect to 404
    	throw new \Exception('File not found :: ' . $className);
    }
});
