<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

abstract class Model {
	
	protected $conn;

	function __construct() {
		$this->conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DBNAME); // pre loading mysqli on each instance

		if($this->conn->connect_error) die('Unable to connect to database.');
	}
}