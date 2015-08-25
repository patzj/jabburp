<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class View {

	function __construct($file, $data) {
		require ROOT . DS . 'application' . DS . 'view' . DS . 'include' . DS . 'header.php';
		require $file; // require view file
		require ROOT . DS . 'application' . DS . 'view' . DS . 'include' . DS . 'footer.php';

	}
}