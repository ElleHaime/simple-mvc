<?php

namespace Frontend\Model;

use Lib\Model,
	Lib\Utils as U;

class ExerciseImage extends Model
{
	/**
	* Unique ID
	* @var int
	*/
	public $id;

	/**
	* Image name
	* @var string
	*/
	public $image;

	/**
	* Exercise ID
	* @var int
	*/
	public $exercise_id;



	public function initialize()
	{
		$this -> belongsTo('exercise_id', 'Frontend\Model\Exercise', 'id', 'exercise');
	}


	public function save($data)
	{
		$properties = [];

		foreach ($data as $property => $value) {
			if (property_exists($this, $property)) {
				$properties[$property] = $value;
			}
		}

		foreach ($this -> belongsTo as $prop => $val) {
			$propertyName = $val['foreignKey']; 
			$properties[$propertyName] = $this -> $propertyName;
		}
U::dump($properties);
		return parent::save($properties);
	}
}