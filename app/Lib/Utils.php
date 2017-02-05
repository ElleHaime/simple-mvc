<?php

namespace Lib;

class Utils
{
	public static function dump($data, $mustDie = true)
	{
		echo '<pre>';
		var_dump($data);
		echo '</pre>';

		if ($mustDie) {
			die();
		}
	}


	public static function arrayToObject($data) {
		$obj = new \stdClass;

		foreach($data as $k => $v) {
			if(strlen($k)) {
				if(is_array($v)) {
					$obj -> {$k} = self::arrayToObject($v); 
				} else {
					$obj -> {$k} = $v;
				}
			}
		}

		return $obj;
	} 
}