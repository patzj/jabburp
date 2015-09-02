<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Home extends Controller {

	function __construct() {
		parent::__construct();
	
		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
	}

	function index() {
		$data['title'] = 'Home';
		$this->view = $this->load->view('Home_view', $data);
	}

	private function contact_id_list() {
		$data['uid'] = $_SESSION['uid'];

		$this->model = $this->load->model('Home_model');
		$result = $this->model->get_contact_id_list($data);

		unset($this->model);
		return $result; // could be false or array of uid's
	}

	function contact_details() {
		$data = self::contact_id_list();
		$this->model = $this->load->model('Home_model');
		foreach($data as $uid) {
			$result[] = $this->model->get_contact_details($uid);
		} 

		unset($this->model);
		return $result; // will return false if query fails anyway
	}
}