<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Router {

	function default_page() {
		header('location: /jabburp/' . DEFAULT_CONTROLLER);
	}

	function controller_not_found() {
		header('location: /' . DEFAULT_ERR_CONTROLLER . '/#');
	}

	function function_not_found() {
		header('location: /jabburp/' . DEFAULT_ERR_CONTROLLER . '/#');
	}
}