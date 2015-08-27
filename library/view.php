<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class View {

	function __construct($file, $data) {
		require_once ROOT . DS . 'application' . DS . 'view' . DS . 'include' . DS . 'header.php';
		require_once $file; // require view file
		require_once ROOT . DS . 'application' . DS . 'view' . DS . 'include' . DS . 'footer.php';

	}
}