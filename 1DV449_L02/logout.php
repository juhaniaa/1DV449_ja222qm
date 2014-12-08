<?php
if(isset($_POST["logout"])){
	require_once("sec.php");
	sec_session_start();	
	unset($_SESSION["login_string"]);
	header('Location: index.php');	
}
