<?php

namespace Lib;

use Lib\ModelFactory,
	Lib\Utils as U;

class Controller
{
	protected $view;
	protected $router;
	protected $modelFactory;
	protected $request;
	protected $logger;


	public function __construct(Router $router, View $view, ModelFactory $modelFactory)
	{
		$this -> router = $router;
		$this -> view = $view;
		$this -> modelFactory = $modelFactory;
	}


	public function loadModel($modelName)
	{
		$model = $this -> modelFactory -> createModel('Frontend\Model\\' . $modelName);

		return $model;
	}


	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this -> $property;
   		}
 	}


	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this -> $property = $value;
		}

		return $this;
	}
}
