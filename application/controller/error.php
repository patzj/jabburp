<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Error extends Controller {

	function index() {
		$this->load->view('Error_view');
	}
}