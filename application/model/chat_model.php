<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Chat_model extends Model {

	function get_message($data) {
		extract($data);
		$current = (string)$current; // making sure that these two
		$other = (string)$other; // will be strings

		$stmt = $this->conn->prepare("SELECT * FROM message 
			WHERE conv_id = (SELECT conv_id FROM conversation 
			WHERE users = CONCAT(?, ', ', ?)
			OR users = CONCAT(?, ', ', ?)) ORDER BY date_time LIMIT 50"); // please work
		$stmt->bind_param('ssss', $current, $other, $other, $current);
		$stmt->execute();
		$result = $stmt->get_result();

		$data = false;
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}

		unset($result);
		$stmt->free_result();
		$stmt->close();

		return $data;
	}

}