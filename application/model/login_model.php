<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Login_model extends Model {

	function verify($data) {
		extract($data); // extract passed data from controller
		unset($data); // unset data

		$stmt = $this->conn->prepare('SELECT uid, username FROM account WHERE 
			username=? AND password=?'); // prepare query for account
		$stmt->bind_param('ss', $username, $password); // bind data
		$stmt->execute(); // execute query
		$stmt->store_result(); // store result; to be fetched

		if($stmt->num_rows == 1) { // check for hit
			$stmt->bind_result($uid, $username); // bind stored data to variables
			$stmt->fetch(); // fetch the stored data
			
			$data = [
				'uid' => $uid,
				'username' => $username
			]; // set return data
		}

		$stmt->free_result(); // free stored results
		$stmt->close(); // close prepared statement
		
		return $data; // return data; either null or assoc array
	}
}	