<?php

namespace Lib;

use Lib\Utils as U;

class View
{
	protected $tplPath			= null;
	protected $compiled			= null;
	protected $tplVars		 	= [];
	protected $viewMode			= null;
	protected $defaultLayout	= 'layout';


	public function __construct($tplPath, $viewMode, $compiledPath = null)
	{
		$this -> tplPath = $tplPath;
		$this -> viewMode = $viewMode;
		$this -> compiledPath = $compiledPath;

		return $this;
	}


	public function setVar($varName, $varValue)
	{
		$this -> tplVars[$varName] = $varValue;

		return $this;
	}


	public function getVar($varName)
	{
		if (isset($this -> tplVars[$varName])) {
			return $this -> tplVars[$varName];
		} else {
			return false;
		}
	}


	public function getVars()
	{
		return $this -> tplVars;
	}


	public function show($template)
	{
		switch($this -> viewMode) {
			case 'tpl':
					$output = $this -> showTpl($template);
				break;	

			default:
				$output = $this -> showHtml($template);
		}

		return $output;
	}


	private function showHtml($template)
	{
		$this -> setVar('currentTemplate', $this -> tplPath . $template . '.php');
		$this -> setVar('currentJs', $template);

		ob_start();
		ob_implicit_flush(false); 
		extract($this -> tplVars);
		require($this -> tplPath . $this -> defaultLayout . '.php');

		return ob_get_clean();
	}

}