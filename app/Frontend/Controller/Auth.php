<?php

namespace Frontend\Controller;

use Lib\Controller,
	Lib\Utils as U;

class Auth extends Controller
{
	/**
	* @Route(/auth)
	* @Acl(admin,user)
	*/
	public function authAction()
	{
		U::dump('weeeeeeeee, I\'m in auth!!!!!');
	}

}