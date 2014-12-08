<?php
require_once("get.php");
require_once("post.php");
require_once("sec.php");

/*
* It's here all the ajax calls goes
*/

if(isset($_POST['function'])){
	if($_POST['function'] == 'add'){
		$tempName = $_POST["name"];
		$tempMessage = $_POST["message"];
		
		$message = trim($tempName);
		$message = htmlspecialchars($tempName);
		
		$name = trim($tempMessage);
		$name = htmlspecialchars($tempMessage);
		
		addToDB($message, $name);	
	}
}

if(isset($_GET['function'])) {
	if($_GET['function'] == 'getMessages') {
  	   	echo(json_encode(getMessages()));
    }
}