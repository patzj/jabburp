<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
require ROOT . DS . 'config.php';

$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DBNAME); // create mysqli object

if($conn->connect_error) die('Unable to connect to database');

if(array_key_exists('username', $_POST)) { // check existence of input from ajax/post
	check_availability('account', 'username', $_POST['username']); // call function for checking db
}

function check_availability($table, $search, $key) {
	global $conn; // include global var to function
	$stmt = $conn->prepare("SELECT * FROM $table WHERE $search = ?"); // prepare query
	$stmt->bind_param('s', $key); // bind param to query
	$stmt->execute(); // execute
	$stmt->store_result(); // store query result

	$result = 'available'; // check availability of key on db
	if($stmt->num_rows > 0) $result = 'not available';

	echo json_encode($result); // encode result for ajax/post callback
}