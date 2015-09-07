<?php if(!defined('BASEPATH')) die('Direct script access not allowed.');

class Chat_model extends Model {

	function get_conversation_id($data) { // get conv_id between users
		extract($data);
		$current = (string)$current; // making sure that data are string
		$other = (string)$other; // to match db format

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

		$stmt = $this->conn->prepare("SELECT message.msg_id, message.content, 
			message.date_time, message.conv_id, account.username # i'm getting the username
			FROM message LEFT JOIN account # from account table using left join;
			ON message.user = account.uid # for display purposes on view
			WHERE conv_id = (SELECT conv_id FROM conversation 
			WHERE users = CONCAT(?, ', ', ?)
			OR users = CONCAT(?, ', ', ?)) ORDER BY date_time LIMIT 50"); // does work
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
		$stmt->close();

		return $data;
	}

	function insert_message($data) {
		extract($data);

		$stmt = $this->conn->prepare('INSERT INTO message(content, user, date_time, conv_id) 
			VALUES(?, ?, NOW(), ?)');
		$stmt->bind_param('sii', $message, $current, $conv_id);
		$result = $stmt->execute();
		$stmt->close();

		return $result;
	}

	function max_message($conv_id) {
		$conv_id = (int)$conv_id; // making sure this is int
		$stmt = $this->conn->prepare('SELECT MAX(msg_id) FROM message 
			WHERe conv_id = ?');
		$stmt->bind_param('i', $conv_id);
		$stmt->execute();
		$stmt->store_result();

		$result = false;
		if($stmt->num_rows == 1) {
			$stmt->bind_result($result);
			$stmt->fetch();
		}

		$stmt->free_result();
		$stmt->close();

		return $result;
	}
}