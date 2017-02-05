<?php

namespace Lib;

class Logger
{
	public $logPath;

	public function __construct($logPath)
	{
		$this -> logPath = $logPath;
	}

	public function log($message, $type = 'App', $file = 'unknown')
	{
		$log = fopen($this -> logPath, 'w+');
		fwrite($log, $type . " error: " . $message . "\n\rFile: " . $file . "\n\r\n\r");
		fclose($log);
	}
}