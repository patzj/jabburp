<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Profile_model extends Model {

	function get_user_info($uid) {
		$stmt = $this->conn->prepare('SELECT * FROM user_info 
			WHERE uid=?'); // prepare query for user_info
		$stmt->bind_param('i', $uid); // bind param
		$stmt->execute(); // execute query
		$result = $stmt->get_result(); // get results; no more storing.. works this way

		if($result->num_rows == 1) { // check num of rows returned
			while($row = $result->fetch_assoc()) {
				$data = $row; // pass row content to data array
			}
		} else return false; // return false if no rows returned
		$stmt->close(); // close current prepare statement

		$stmt = $this->conn->prepare('SELECT email FROM account 
			WHERE uid=?'); // prepare query to get email
		$stmt->bind_param('i', $uid); // bind param
		$stmt->execute(); // execute
		$stmt->store_result(); // store result

		if($stmt->num_rows == 1) { // if returned num of rows is 1
			$stmt->bind_result($email); // bind result
			$stmt->fetch(); // fetch stored result
		}

		$stmt->free_result(); // free stored result
		$stmt->close(); // close prepare statement

		$data['email']  = $email; // add email to existing data array

		return $data;
	}

	function update_user_info($data, $uid) {
		extract($data);

		$stmt = $this->conn->prepare('UPDATE user_info 
			SET firstname = ?, lastname = ?, gender = ?, about = ? 
			WHERE uid = ?'); // prepare query 
		$stmt->bind_param('ssssi', $firstname, $lastname, $gender, $about, $uid); // bind param
		$result = $stmt->execute(); // execute

		$stmt->close(); // close prepare statement

		return $result;
	}
}