<?php
require_once("sec.php");
require_once("get.php");

// user is logged already
if(isUserLogged()){
	header("Location: mess.php"); 	
// user is trying to login
} else if(isset($_POST["login"])){
	$up = $_POST['username'];
	$pp = $_POST['password'];
	
	// check tha POST parameters
	if(isset($up) && isset($pp)){
		$u = clean_input($up);
		$p = clean_input($pp);		
		
		// Check if user is OK
		if(isset($u) && isset($p) && isUser($u, $p)) {
					
			// set the session
			sec_session_start();
			$_SESSION['username'] = $u;		
			$aip = $_SERVER["REMOTE_ADDR"];
			$bip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			$agent = $_SERVER["HTTP_USER_AGENT"];			
			$_SESSION["login_string"] = hash("sha256", $aip . $bip . $agent);	
			header("Location: mess.php"); 
		}
		else {
			// if wrong credentials
			saveMessage("error", "wrong credentials");
			header("Location: index.php"); 
		}
	// if user not logged and params not set
	} else {
		header("Location: index.php");
	}
// if user is not logged and not trying to log in
} else {
	header("Location: index.php");
}
