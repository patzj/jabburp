<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

abstract class Controller {

	protected $model;
	protected $view;
	protected $helper;
	protected $load;

	function __construct() {
		$this->helper = new Helper(); // helper obj
		$this->load = new Loader(); // loader obj
	}

	function __destruct() {
		unset($this->helper); // unset helper obj
		unset($this->load); // unset loader obj
	}
}