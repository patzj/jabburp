<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Chat_model extends Model {

	function get_conversation_id($data) { // get conv_id between users
		extract($data);
		$current = (string)$current; // making sure that data are string
		$other = (string)$other;

		$stmt = $this->conn->prepare("SELECT conv_id FROM conversation 
			WHERE users = CONCAT(?, ', ', ?) 
			OR users = CONCAT(?, ', ', ?)"); // get conv_id prepare statement
		$stmt->bind_param('ssss', $current, $other, $other, $current); // bind param
		$stmt->execute(); // execute query
		$stmt->store_result(); // store result

		$data = false;
		if($stmt->num_rows == 1) { // check num of rows returned
			$stmt->bind_result($data); // bind result to var for fetching
			$stmt->fetch(); // fetch result
		}

		$stmt->free_result(); // free result
		$stmt->close(); // close prepare statement

		return $data;

	}

	function set_conversation_id($data) { // insert conv_id for two users
		extract($data);
		$users = $current . ', ' . $other; // inline var with db format

		$stmt = $this->conn->prepare('INSERT INTO conversation(users) 
			VALUES(?)'); // prepare statement
		$stmt->bind_param('s', $users); // bind param

		$data = false;
		if($stmt->execute()) { // if query was success
			$data = $this->conn->insert_id; // set last insert id to data
		} 

		$stmt->close(); // close prepared statment
		return $data;
	}

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

	function insert_message($data) {

	}

}