<?php if(!defined('BASEPATH')) die('Direct script access not allowed');

class Join_model extends Model {

	function insert($data){
		extract($data); // extract passed data from controller
		$date = date("Y-m-d"); // get current date
		$stmt = $this->conn->prepare('INSERT INTO account
			(username, password, email, join_date) 
			VALUES(?, ?, ?, ?)'); // prepare query for account; added error
		$stmt->bind_param('ssss', $username, md5($password), $email, $date); // bind data
		if($stmt->execute(1)) { // execute query; check for success/fail
			$stmt->close(); // close prior prepare statement
			$last_id = $this->conn->insert_id; // get last insert id
			$stmt = $this->conn->prepare('INSERT INTO user_info
				(uid, firstname, lastname, gender) 
				VALUES(?, ?, ?, ?)'); // prepare query for user_info
			$stmt->bind_param('isss', $last_id, $firstname, $lastname, $gender); // bind data
			if($stmt->execute()) { // execute query; check for success/fail
				$stmt->close(); // close prepared statement
				return true;
			}
		}
		$stmt->close(); // close prepared statement
		return false;
	}
}