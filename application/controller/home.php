<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Home extends Controller {

	function __construct() {
		parent::__construct();
	
		session_start();
		if(!isset($_SESSION['username'])) header('location: ' . BASEPATH . 'login');
		session_write_close();
	}

	function index() { 
		$data['title'] = 'Home';
		$data['name'] = self::user()['name'];
		$data['contact_list'] = self::contact_details();
		$this->view = $this->load->view('Home_view', $data);
		unset($this->view);
	}

	function contact_status() {
		if(empty($_POST)) die('Direct script acccess not allowed');

		$username = $_POST['data'];
		$uid = self::get_uid($username);
		$this->model = $this->load->model('Home_model');
		$result = $this->model->get_contact_status($uid);

		if($result) {
			echo json_encode($result);
		} else {
			echo json_encode('');
		}

		unset($this->model);
	}

	private function get_uid($username) {
		$this->model = $this->load->model('Helper_model');
		$uid = $this->model->get_uid($username);
		unset($this->model);

		return $uid;
	}

	private function user() { // get user info using uid
		$this->model = $this->load->model('Home_model');
		return $this->model->get_contact_details($_SESSION['uid']);
	}

	private function contact_list() { // get contact list using uid
		$data['uid'] = $_SESSION['uid'];

		$this->model = $this->load->model('Home_model');
		$result = $this->model->get_contact_list($data);

		unset($this->model);
		return $result; // could be false or array of uid's
	}

	private function contact_details() { // get details of contacts
		$data = self::contact_list();
		$this->model = $this->load->model('Home_model');
		foreach($data as $uid) {
			$result[] = $this->model->get_contact_details($uid);
		} 

		unset($this->model);
		return $result; // will return false if query fails anyway
	}
}