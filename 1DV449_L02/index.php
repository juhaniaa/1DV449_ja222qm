<?php
	require_once("sec.php");	
	require_once("get.php");
	sec_session_start();
	
	if(isUserLogged()){
		header("Location: mess.php");
	}
	
	$message = loadMessage("error");
	$head = getHeader(); 

	$html = $head;
	$html .= '
		  <body>
		    <div class="container">
		      <form class="form-signin" action="check.php" method="POST">
		      	<h2>';
		      	$html .= $message;
				$html .='
		      		</h2>
		        <h2 class="form-signin-heading">Log in</h2>
		        <input value="" name="username" type="text" class="form-control" placeholder="Användarnamn" required autofocus>
		        <input value="" name="password" type="password" class="form-control" placeholder="Password" required>
		        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login">Log in</button>
		      </form>
		    </div> <!-- /container -->
		    
		    <!-- JS -->
		    <script src="js/jquery.js"></script>
			<script src="js/bootstrap.js"></script>
		  </body>
		</html>';
		
		echo $html;

