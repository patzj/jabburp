<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Chat extends Controller {

	function __construct() {
		parent::__construct();

		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		// some codes
	}

	function display() {
		if(empty($_POST)) die('Direct script access not allowed.');
		
		$current = $_SESSION['username'];
		$other = $_POST['data'];

		$this->model = $this->load->model('Helper_model');
		$current = $this->model->get_uid($current);
		$other = $this->model->get_uid($other);
		unset($this->model);

		$data = [
			'current' => $current,
			'other' => $other
		];
		
		$this->model = $this->load->model('Chat_model');
		$result = $this->model->get_message($data);

		if($result) {
			echo json_encode($result);
		} else echo json_encode('');

		unset($data);
		unset($result);
		unset($this->model);
	}
}