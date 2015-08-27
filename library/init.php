<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Init {

	protected $controller;
	protected $router;

	function __construct() {
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = explode('/', $url);
		
		if(empty($url[0])) { // check class or controller in url
			$this->router = new Router(); // default controller
			$this->router->default_page();
			return false;
		} else {
			$file = ROOT . DS . 'application' . DS . 'controller' . DS . $url[0] . '.php';
			if(file_exists($file)) { // check controller existence
				require_once $file; // require controller
				$url[0] = ucfirst(strtolower($url[0])); 
				$this->controller = new $url[0]();
			} else {
				$file = ROOT . DS . 'application' . DS . 'controller' . DS . 'error.php';
				$this->router = new Router();
				$this->router->controller_not_found(); // landing page if controller is not found
				return false;
			}
		}

		if(empty($url[1])) { // check function in url
			$this->controller->index(); // default function
			return false;
		} else {
			$url[1] = strtolower($url[1]);
			if(method_exists($this->controller, $url[1])) { // check function existence
				$this->controller->$url[1]();
			} else {
				$this->router = new Router();
				$this->router->function_not_found(); // landing page if fuction is not found
				return false;
			}
		}	
	}
}