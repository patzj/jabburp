<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Signup_model extends Model {

	function insert($data){
		extract($data); // extract passed data from controller
		unset($data); // unset data
		$date = date("Y-m-d"); // get current date

		$stmt = $this->conn->prepare('INSERT INTO account
			(username, password, email, signup_date) 
			VALUES(?, ?, ?, ?)'); // prepare query for account
		$stmt->bind_param('ssss', $username, $password, $email, $date); // bind data

		if($stmt->execute()) { // execute query; check for success/fail
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

	function validate($data) {
		extract($data); // extract POST
		unset($data);

		$stmt = $this->conn->prepare("SELECT * FROM account
			WHERE $column = ?"); // prepare query for account
		$stmt->bind_param('s', $key); // bind param
		$stmt->execute(); // execute query
		$stmt->store_result(); // store result

		$result = '';
		if($stmt->num_rows > 0) $result = 'not available'; // check no of rows returned

		$stmt->free_result(); // free stored result
		$stmt->close(); // close prepared statement
		return $result;
	}
}