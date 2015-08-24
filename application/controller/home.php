<?php

class Home extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$this->load->view('Home_view');
	}

	function another() {
		echo 'this is another function';
	}
}