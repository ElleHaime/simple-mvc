<?php

namespace Frontend\Model;

use Lib\Model,
	Lib\Utils as U;

class Exercise extends Model
{
	/**
	* Unique ID
	* @var int
	*/
	public $id;

	/**
	* Author name
	* @var string
	*/
	public $username;

	/**
	* Author email
	* @var string
	*/
	public $email;

	/**
	* Excerise description
	* @var string
	*/
	public $exercise;

	/**
	* Status, solved or not
	* @var boolean
	*/
	public $status;



	public function initialize()
	{
		$this -> hasMany('id', 'Frontend\Model\ExerciseImage', 'exercise_id', 'image');
	}


	public function save($data)
	{
		$properties = [];

		foreach ($data as $property => $value) {
			if (property_exists($this, $property)) {
				$properties[$property] = $value;
			}
		}

		return parent::save($properties);
	}
}
