<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Search extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		$data['title'] = 'Search';
		$this->view = $this->load->view('Search_view', $data);
	}

	function user() {
		if(empty($_POST)) die('Direct script access not allowed.');
		extract($_POST); // this data contains any of the ff: username, email, firstname, lastname
		
		$this->model = $this->load->model('Search_model');
		$result = $this->model->get_user_info($data);
		if($result) echo json_encode($result);
		else echo json_encode('not found');
	}
}