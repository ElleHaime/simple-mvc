<?php

namespace Frontend\Controller;

use Lib\Controller,
	Lib\Utils as U;

class Exercise extends Controller
{
	/**
	* @Route(/)
	* @Acl(admin,user)
	*/
	public function indexAction()
	{
		$exercises = $this -> loadModel('Exercise') 
						   -> find();
		$this -> view -> setVar('exercises', $exercises);
		
		return $this -> view -> show('index');
	}


	/**
	* @Route(/add)
	* @Acl(admin,user)
	*/
	public function addAction()
	{
		if ($this -> request -> get('post')) {
			$newExercise = $this -> loadModel('Exercise') 
								 -> save($this -> request -> get('post'));

			if ($newExercise) {
				if ($files = $this -> request -> get('files')['image']) {
					$newExerciseImage = $this -> loadModel('ExerciseImage')
											  -> setBelongsToProperty('exercise', $newExercise -> id)
											  -> save($files);
					U::dump($newExerciseImage);				
				}
			}
U::dump($newExercise);

		}

		return $this -> view -> show('add');
	}


	/**
	* @Route(/edit/{postId:[\d+]})
	* @Acl(admin,user)
	*/
	public function editAction($postId)
	{

	}

}