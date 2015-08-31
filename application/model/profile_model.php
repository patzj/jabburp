<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Profile_model extends Model {

	function retrieve($user) {
		$stmt = $this->conn->prepare('SELECT uid, email FROM account 
			WHERE username=?'); // prepare query for account 
		$stmt->bind_param('s', $user); // bind param
		$stmt->execute(); // execute query
		$stmt->store_result(); // store results

		if($stmt->num_rows == 1) { // check num of rows returned
			$stmt->bind_result($uid, $email); // bind stored data
			$stmt->fetch(); // fetch stored data
			$stmt->free_result(); // free stored data
			$stmt->close(); // close prepare statement
		} else return false; // stop further script exec; return false if no rows returned

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

		$data['email'] = $email; // additional info

		return $data;
	}
}