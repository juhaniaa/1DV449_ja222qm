<?php
	require_once("sec.php");	
	require_once("get.php");
	sec_session_start();
	
	if(isUserLogged()){
		header("Location: mess.php");
	}
	
	$message = loadMessage("error"); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.png">

    <title>Mezzy Labbage - Logga in</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/dyn.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
  </head>

  <body>
    <div class="container">
      <form class="form-signin" action="check.php" method="POST">
      	<h2><?php
      		echo $message
      		?></h2>
        <h2 class="form-signin-heading">Log in</h2>
        <input value="" name="username" type="text" class="form-control" placeholder="Användarnamn" required autofocus>
        <input value="" name="password" type="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login">Log in</button>
      </form>
    </div> <!-- /container -->
    
    
  </body>
</html>

