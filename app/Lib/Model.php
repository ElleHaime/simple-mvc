<?php

namespace Lib;

use Lib\Utils as U,
	Lib\ModelFactory;


class Model
{
	protected $db 					= null;
	protected $modelFactory 		= null;
	protected $source 				= null;
	protected $primaryKey			= 'id';
	protected $hasMany 				= [];
	protected $belongsTo 			= [];
	protected $result 				= false;



	public function __construct(Database $database, ModelFactory $modelFactory)
	{
		$this -> db = $database;
		$this -> modelFactory = $modelFactory;

		$this -> setSource();
		$this -> initialize();
	}	


	public function loadModel($modelName)
	{
		$model = $this -> modelFactory -> createModel($modelName);
		return $model;
	}


	public function initialize() {}


	public function find($params = [])
	{
		$this -> result = $this -> fetchAll($params);

		if (!empty($this -> result)) {
			foreach ($this -> result as $key => $value) {
				if (!empty($this -> hasMany)) {	
					foreach ($this -> hasMany as $prop => $val) {
						$foreignData = $this -> loadModel($val['foreignModel']) -> fetchAll([$val['referencedKey'] => $value -> $val['foreignKey']]);
						if (!empty($foreignData)) {
							$this -> result[$key] -> $prop = $foreignData;
						}
					}
				}
			}
		}
		return $this -> result;
	}


	public function findOne($params = [])
	{
		$where = $this -> composeParams($params);
		$query = 'SELECT * FROM ' . $this -> source . $where;
		$data = $this -> db -> getOne($query, $params);

		return $data;
	}


	public function update()
	{

	}


	public function save($data)
	{
		$newEntity = false;

		$bindVals = $this -> db -> composeValsFromArray($data);
		$query = 'INSERT INTO ' . $this -> source . '(' . implode(',', array_keys($data)). ') VALUES (' . $bindVals. ')';
		$createNew = $this -> db -> query($query, $data);

		if (!empty($createNew)) {
			$params = [$this -> primaryKey => $this -> db -> lastInsertId()];
			$newEntity = $this -> findOne($params);
		}

		return $newEntity;
	}
 

	public function delete($entityId)
	{
		
	}


	protected function fetchAll($params = [])
	{	
		$where = $this -> composeParams($params);
		$query = 'SELECT * FROM ' . $this -> source . $where;
		$data = $this -> db -> query($query, $params);

		return $data;
	}


	protected function setSource($sourceTable = false)
	{
		if ($sourceTable) {
			$this -> source = $sourceTable;

		} else {
			$modelName = (new \ReflectionClass($this)) -> getShortName();

			preg_match_all('/[A-Z]/', $modelName, $matches, PREG_OFFSET_CAPTURE);
			if (!empty($matches)) {
				$i = 0;
				foreach ($matches[0] as $key => $val) {
					if ($val[1] != '0') {
						$modelName = substr_replace($modelName, '_', $val[1] + $i, 0);
						$i++;
					}
				}
			}
			$this -> source = strtolower($modelName);
		}

		return $this;
	}


	protected function getSource()
	{
		return $this -> source;
	}


	protected function hasMany($foreignKey, $foreignModel, $referencedKey, $alias)
	{
		$this -> hasMany[$alias] = ['foreignKey' => $foreignKey,
									'foreignModel' => $foreignModel,
									'referencedKey' => $referencedKey];

		return $this;
	}


	protected function belongsTo($foreignKey, $foreignModel, $referencedKey, $alias)
	{
		$this -> belongsTo[$alias] = ['foreignKey' => $foreignKey,
										'foreignModel' => $foreignModel,
										'referencedKey' => $referencedKey];

		return $this;
	}


	protected function setPrimaryKey($property)
	{
		$this -> primaryKey = $property;
		return $this;
	}


	public function setBelongsToProperty($referencedKey, $value)
	{
		if (array_key_exists($referencedKey, $this -> belongsTo)) {
			$propertyName = $this -> belongsTo[$referencedKey]['foreignKey'];
			if (property_exists($this, $propertyName)) {
				$this -> $propertyName = $value;
			}
		}

		return $this;
	}


	public function composeParams($params = [])
	{
		$where = '';

		if (!empty($params)) {
			$conditions = [];

			foreach ($params as $key => $value) {
				if (!property_exists($this, $key)) {
					unset($params[$key]); 
				} else {
					$conditions[] = $key . ' = :' . $key;
				}
			}

			$where = ' WHERE ' . implode(' AND ', $conditions);
		}

		return $where;
	}
}