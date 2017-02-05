<?php

namespace Lib;

use Lib\Utils as U;

class Router
{
	protected $routes 		= [];
	protected $routeMethod 	= null;
	protected $routeAction 	= null;
	protected $routeParams 	= null;


	public function __construct()
	{
		$this -> createMap();
		
		return $this;
	}


	public function redirect($url)
	{

	}


	public function processUrl($requestUri)
	{
		$this -> searchInMap($requestUri);

		return $this;
	}	


	public function getMethod()
	{
		return $this -> routeMethod;
	}


	public function getAction()
	{
		return $this -> routeAction;
	}


	public function getParams()
	{
		return $this -> routeParams;
	}


	public function getRoutes()
	{
		return $this -> routes;
	}


	private function createMap()
	{
		$controllesPath = ROOT_APP . 'Frontend' . DIR_SEP . 'Controller';
		$directoryIterator = new \DirectoryIterator ($controllesPath);

		foreach ($directoryIterator as $controllerFile) {
			if ($controllerFile -> isFile()) { 
				$className = pathinfo($controllerFile -> getPathName())['filename'];

				$reflector = new \ReflectionClass('Frontend\Controller\\' . $className);
				foreach ($reflector -> getMethods() as $mappingItem) {
					$docBlock = $reflector -> getMethod($mappingItem -> getName()) -> getDocComment();
					$mapping = $this -> parseRouteBlock($docBlock);
					if ($mapping) {
						$this -> routes[] = ['uri' => $mapping['routeRegex'],
											'resolve' => ['class' => 'Frontend\Controller\\' . $className,
													 	  'action' => $mappingItem -> getName(),
													 	  'paramName' => $mapping['paramName'],
													 	  'paramValue' => $mapping['paramValue'],
													 	  'isStatic' => $mappingItem -> isStatic()]
											];
					}
				}
			}
		}
	}


	private function searchInMap($requestUri)
	{
		foreach ($this -> routes as $key => $route) {
			preg_match($route['uri'], $requestUri, $matches);

			if (!empty($matches)) {
				$this -> routeMethod = $route['resolve']['class'];
				$this -> routeAction = $route['resolve']['action'];
				$this -> routeParam = $matches['paramValue'];
			}
		}
	}


	private function parseAclBlock($docBlock)
	{

	}


	private function parseRouteBlock($docBlock)
	{
		$result = false;

		$pattern = '/@Route\((?P<route>[a-zA-Z0-9\-_\/]*)(\{(?P<paramName>[\w]+):\[(?P<paramValue>.*)\]\})?\)/s';
		preg_match_all($pattern, $docBlock, $matches);

		if (!empty($matches['route'])) {
			$routeRegex = '/^' .  str_replace('/', '\/', $matches['route'][0] . '(?P<paramValue>' . $matches['paramValue'][0]) . ')' . '$/s';

			$result = ['routeRegex' => $routeRegex, 
						'paramName' => $matches['paramName'][0],
						'paramValue' => $matches['paramValue'][0]];
		}	

		return $result;
	}
}