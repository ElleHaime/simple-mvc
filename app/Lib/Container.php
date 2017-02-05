<?php

namespace Lib;

use Lib\Utils as U;


class Container
{
	protected $container = [];


	public function set($serviceName, $serviceCall)
	{
		$this -> container[$serviceName] = $serviceCall;
	}	


	public function get($serviceName)
	{
		if (is_callable($this -> container[$serviceName])) {
            return call_user_func($this -> container[$serviceName]);
        } else {
			throw new \Exception('Service ' . $serviceName . ' not registered');
		}
	}


	public function has($serviceName)
	{
		return array_key_exists($serviceName, $this -> container);
	}
}