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

		return $data;
	}

	function update_user_info($data, $uid) {
		extract($data);

		$stmt = $this->conn->prepare('UPDATE user_info 
			SET firstname = ?, lastname = ?, gender = ?, about = ? 
			WHERE uid = ?');
		$stmt->bind_param('ssssi', $firstname, $lastname, $gender, $about, $uid);
		$result = $stmt->execute();

		$stmt->close();

		return $result;
	}
}