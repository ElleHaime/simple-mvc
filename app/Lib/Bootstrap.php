<?php

namespace Lib;

use Lib\Utils as U,
	Lib\Router,
	Lib\View,
	Lib\Database,
	Lib\ModelFactory,
	Lib\Logger,
	Lib\Image,
	Lib\Request,
	Lib\Container;


class Bootstrap
{
	private $_config 	= null;
	public $container  	= null;
	public $appContent 	= null;


	public function __construct()
	{
		include_once(CONFIG_PATH);
		$this -> _config = U::arrayToObject($config);

		$this -> container = new Container();
	}


	public function run()
	{
		$this -> initDatabase();
		$this -> initRouting();
		$this -> initView();
		$this -> initRequest();
		$this -> initModelFactory();
		$this -> initLogger();
		$this -> initImage();
	}


	private function initDatabase()
	{
		$config = $this -> _config -> database;

		$this -> container -> set('db', function () use ($config) {
			return new Database($config);
		});
	}


	private function initRouting()
	{
		$this -> container -> set('router', function() {
			return new Router();
		});	
	}


	private function initRequest()
	{
		$this -> container -> set('request', function() {
			return new Request();
		});	
	}


	private function initModelFactory()
	{
		$this -> container -> set('modelFactory', function() {
			$database = $this -> container -> get('db');
			return new ModelFactory($database);
		});	
	}


	private function initView()
	{
		$config = $this -> _config -> template;

		$this -> container -> set('view', function() use ($config) {
			$tplDir = ROOT_APP . 'Frontend' . DIR_SEP . 'View' . DIR_SEP . $config -> viewMode . DIR_SEP;

			return new View($tplDir, $config -> viewMode);
		});	
	}


	private function initLogger()
	{
		$config = $this -> _config -> logs;	
		$this -> container -> set('logger', function() use ($config) {
			return new Logger($config -> logPath);
		});
	}


	private function initImage()
	{
		$config = $this -> _config -> images;

		$this -> container -> set('image', function() use ($config) {
			return new Image($config);
		});		
	}


	public function output()
	{
		return $this -> handle() -> getContent();
	}


	protected function handle()
	{
		$router = $this -> container -> get('router');
		$modelFactory = $this -> container -> get('modelFactory');
		$view = $this -> container -> get('view');
		$request = $this -> container -> get('request');
		$logger = $this -> container -> get('logger');

		$router -> processUrl($_SERVER['REQUEST_URI']);

		$methodName = $router -> getMethod();
		$actionName = $router -> getAction();

		if (!empty($methodName) && !empty($actionName)) {
			$controller = new $methodName($router, $view, $modelFactory);
			$controller -> request = $request;
			$controller -> logger = $logger;

			if (!is_null($router -> getParams())) {
				$this -> appContent = $controller -> $actionName($router -> getParams());
			} else {
				$this -> appContent = $controller -> $actionName();
			}
		}	

		return $this;
	}


	protected function getContent()
	{
		echo $this -> appContent;
	}
}