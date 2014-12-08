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

	if(isset($_SESSION["login_string"])){
		if($_SESSION["login_string"] == $ident){
			return true;
		}
	} 
	return false;
}

function getHeader(){
	return '
	<!DOCTYPE html>
	<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    
	    <!-- Icons -->
	    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
	    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
	    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
	    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
	    <link rel="shortcut icon" href="pic/favicon.png">
	    
	    <!-- CSS -->
	    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	    <link rel="stylesheet" type="text/css" href="css/dyn.css" />
	       
		<title>Messy Labbage</title>
  	</head>';
}
