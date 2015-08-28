<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Init {

	private $controller;

	function __construct() {

		$url = @strtolower($_GET['url']); // get url
		$url = rtrim($url, '/'); // remove extra slashes
		$url = explode('/', $url); // split url into array

		$controller = (empty($url[0])) ? DEFAULT_CONTROLLER : $url[0];
		$file = ROOT . DS . 'application' . DS . 'controller' . DS . $controller . '.php';
		if (!file_exists($file)) { // check file existence; reassignment if not exist
			$controller = DEFAULT_ERR_CONTROLLER;
			$file = ROOT . DS . 'application' . DS . 'controller' . DS . $controller . '.php';
		}

		require_once $file; // require controller file
		$controller = ucfirst($controller);
		$this->controller = new $controller(); // assign controller obj to instance var
		
		$action = (!empty($url[1]) && method_exists($this->controller, $url[1])) ?
			$url[1] : DEFAULT_ACTION; // check url and method existence; assign to default if false

		$this->controller->$action(); // call action
	}
}