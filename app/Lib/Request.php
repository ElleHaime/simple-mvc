<?php

namespace Lib;

class Request
{
	protected $post 	= false;
	protected $get 		= false;
	protected $files 	= false;


	public function __construct()
	{
		if (!empty($_POST)) {
			$this -> post = $_POST;
		}

		if (!empty($_GET)) {
			$this -> get = $_GET;
		}

		if (!empty($_FILES)) {
			$this -> files = $_FILES;
		}
	}


	public function get($key)
	{
		$property = strtolower($key);
		if (property_exists($this, $property)) {
			return $this -> $property;
		}
	}
}