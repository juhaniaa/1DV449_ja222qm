<?php

// get the specific message
function getMessages() {
	$db = null;

	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Del -> " .$e->getMessage());
	}
	
	$q = "SELECT * FROM messages";
	
	$result;
	$stm;	
	try {
		$stm = $db->prepare($q);
		$stm->execute();
		$result = $stm->fetchAll();
	}
	catch(PDOException $e) {
		echo("Error creating query: " .$e->getMessage());
		return false;
	}
	
	if($result)
		return $result;
	else
	 	return false;
}

function saveMessage($cookieName, $cookieInfo) {
	setcookie($cookieName, $cookieInfo, time()+3600);
	$_COOKIE[$cookieName] = $cookieInfo;
}

function loadMessage($cookieName) {
	if (isset($_COOKIE[$cookieName])){
		$ret = $_COOKIE[$cookieName];
	}
	else {
		$ret = "";
	}
	setcookie($cookieName, "", time() -1);
	return $ret;
}

function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function isUserLogged(){
	$aip = $_SERVER["REMOTE_ADDR"];
	$bip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	$agent = $_SERVER["HTTP_USER_AGENT"];
	
	$ident = hash("sha256", $aip . $bip . $agent);
	
	
	/*
	//echo $ident;
	//echo "</br>";
	echo $_SESSION["login_string"];
	echo $_SESSION["login_string"];
	$yolo = $_SESSION["login_string"];
	print($yolo);
	echo $yolo;
	
	
	echo isset($_SESSION["login_string"]);
	echo "hello";
	
	 * 
	
	var_dump($ident);
	var_dump($_SESSION["login_string"]);
	die();*/
	
	
	if(isset($_SESSION["login_string"])){
		if($_SESSION["login_string"] == $ident){
			return true;
		}
	} 
	return false;
}