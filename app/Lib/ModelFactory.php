<?php

namespace Lib;

use Lib\Model,
	Lib\Database,
	Lib\Utils as U;


class ModelFactory
{
	private $db;


	public function __construct(Database $database)
	{
		$this -> db = $database;
	}


	public function createModel($modelName)
	{
		return new $modelName($this -> db, $this);
	}
}