<?php

/**
* Called from AJAX to add stuff to DB
*/
function addToDB($message, $user) {
	$db = null;
	
	$message = trim($message);
	$message = stripslashes($message);
	$message = htmlspecialchars($message);

	$user = trim($user);
	$user = stripslashes($user);
	$user = htmlspecialchars($user);
	
	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Something went wrong -> " .$e->getMessage());
	}
	
	$q = "INSERT INTO messages (message, name) VALUES(?, ?)";
	$params = array($message, $user);
	
	try {		
		$query = $db->prepare($q);
		$result = $query->execute($params);	
		//echo "Message saved by user: " .json_encode($result);				
	}
	catch(PDOException $e) {
		die("Something went wrong -> " . $e->getMessage());
	}
}

