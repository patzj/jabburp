<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Loader {

	function model($class) {
		$model = strtolower($class); // to lower for require
		$file = ROOT . DS . 'application' .  DS . 'model' . DS . $model . '.php';
		if(file_exists($file)) { // check class file existence
			require_once $file; // require class file
			return new $class(); // return model object
		} return false;
	}

	function view($view, $data) {
		$view = strtolower($view); // to lower for require
		$file = ROOT . DS . 'application' . DS . 'view' . DS . $view . '.php';
		if(file_exists($file)) {
			return new View($file, $data); // return view object
		} return false;
	}
}