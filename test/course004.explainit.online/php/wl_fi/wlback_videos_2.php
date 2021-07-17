<?php
//SESSION START
	session_start();

//ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

//SSL
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}

//USER IS LOGGED IN
	if ($_SESSION['loggedin'] == 1)//user came from authentication
	{
		//SESSION VAR	
		$_SESSION["example"] = 1;
		$_SESSION["refresh_count"] = 1;
			
		//SESSION VAR PAID IS SET
		if(isset($_SESSION['paid']))
		{
			//USER NEEDS TO PAY
			if ($_SESSION['paid'] == 'N')
			{
				//SESSION VAR
				$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>מיד תועבר/י לדף התשלום</h1><h4 id='c' style='margin:2px auto;'>חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא\"ל</h4>";	
				
				//PAYMENT PAGE//OUTPUT 00
				echo '<script>setTimeout(function(){$("#d").click();}, 4000);</script>';
			}//USER NEEDS TO PAY
			
			//USER DOESN'T NEED TO PAY
			else
			{		
				//SESSION VAR
				$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>התנתקות מוצלחת</h1><h4 id='c' style='margin:2px auto;'>את/ה מועבר/ת להתחברות מחדש</h4>";	
				
				//REDIRECTED TO LOGIN PAGE//OUTPUT 01
				echo '<script>setTimeout(function(){document.getElementById("F_link").click();}, 2000);</script>';
			
			}//USER DOESN'T NEED TO PAY
		}//SESSION VAR PAID IS SET

		//SESSION VAR PAID ISN'T SET
		else
		{		
			//SESSION VAR
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>התנתקות מוצלחת</h1><br><h4 id='c' style='margin:2px auto;'>את/ה מועבר/ת להתחברות מחדש</h4>";	
			
			//REDIRECTED TO LOGIN PAGE//OUTPUT 02
			echo '<script>setTimeout(function(){document.getElementById("F_link").click();}, 2000);</script>';
			
		}//SESSION VAR PAID ISN'T SET
	}//USER IS LOGGED IN
	
	//USER ISN'T LOGGED IN//DIRECT ACCESS
	else
	{
		//ERROR PAGE//OUTPUT 03
		header ("location: ../error_fi/error_videos.php");
	
	}//USER ISN'T LOGGED IN
?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 04 -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 05 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 06 -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style>
/* TEMPLATE */

	body
		{
			/* Background pattern from Toptal Subtle Patterns */
			background-image:url(../../img/background/grey_wash_wall.png);
			color:#f1f1f1;
			font-family:Secular One, Sans Serif;
			box-sizing:border-box;
		}
		
	hr	
		{
			border-top:1px solid #f1f1f1;
		}
		
	input[type="submit"],input[type="email"],input[type="text"],input[type="password"]
		{
			font-family:secular one, sans-serif;
		}
	
	a	{
			text-decoration:none;
			color:#54c539;
		}
</style>	
</head>

<body>
<!-- CONTENT DIV -->
<div id="d" class="content" style="direction:rtl;text-align:center;">
	<!-- TEXT -->
	<?=$_SESSION['message_1'];?>
	
	<!-- LOGIN PAGE --><!-- OUTPUT 07 -->
	<div class="user">
		<h4><a id="F_link" href="../../login/example_cleveland_l_videos.php"></a></h4> 
	</div>
</div><!-- CONTENT DIV -->

<script>
$("#d").click(function(){
	//PAYMENT PAGE//OUTPUT 08
	window.location.replace("https://direct.tranzila.com/ttxxo001004/");
});
</script>
</body>