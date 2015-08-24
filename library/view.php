<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class View {

	protected $data;

	function __construct($file, $data) {
		require $file; // require view file
	}
}