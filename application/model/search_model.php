<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Search_model extends Model {

	function get_user_info($search_key) { 
		$stmt = $this->conn->prepare("SELECT account.username, 
			CONCAT(user_info.firstname, ' ', user_info.lastname) AS name 
			FROM account RIGHT JOIN user_info
			ON account.uid = user_info.uid 
			WHERE account.username = ? OR account.email = ?"); // fuckin insane query for my current level
		$stmt->bind_param('ss', $search_key, $search_key);
		$stmt->execute();
		$stmt->store_result();

		$data = false;
		if($stmt->num_rows > 0) {
			$stmt->bind_result($username, $name);
			$stmt->fetch();
			$data = [
				'username' => $username,
				'name' => $name
			];
		}

		unset($search_key);
		$stmt->free_result();
		$stmt->close();
		return $data;
	}
}