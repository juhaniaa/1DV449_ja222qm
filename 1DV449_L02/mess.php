<?php
	require_once("get.php");
	require_once("sec.php");
	sec_session_start();
		
	if(!isUserLogged()){
		header("Location: index.php");
	}
	$head = getHeader();

	$html = $head;
	$html .= '
		<body background="http://www.lockley.net/backgds/big_leo_minor.jpg">        
	    <div id="container">
	        
	        <div id="messageboard">
	            
	            <form action="logout.php" method="POST">      	                       
			        <button class="btn btn-danger" type="submit" id="logout" name="logout" value="logout">Log out</button>
			  	</form>
			  	
	            <div id="messagearea"></div>
	            
	            <p id="numberOfMess">Antal meddelanden: <span id="nrOfMessages">0</span></p>
	            Name:<br /> <input id="inputName" type="text" name="name" /><br />
	            Message: <br />
	            <textarea name="mess" id="inputText" cols="55" rows="6"></textarea>
	            <input class="btn btn-primary" type="button" id="buttonSend" value="Write your message" />
	            <span class="clear">&nbsp;</span>
	
	        </div>
	
	    </div>
	    
	    <!-- JS -->	
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/jquery.js"></script>
		<!--<script type="text/javascript" src="js/longpoll.js"></script>-->		
		<script src="js/jquery.js"></script>
		<script src="MessageBoard.js"></script>
		<script src="js/script.js"></script>
		<script src="Message.js"></script>
	</body>
	</html>';
	
	echo $html;
