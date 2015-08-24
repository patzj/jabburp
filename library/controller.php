<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

abstract class Controller {

	protected $model;
	protected $helper;
	protected $load;

	function __construct() {
		$this->helper = new Helper(); // helper object
		$this->load = new Loader(); // loader object
	}
}