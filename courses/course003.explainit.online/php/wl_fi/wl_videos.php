<?php
//SESSION START	
	session_start();

// DISPLAY ERRORS
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

// SSL
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

//USER DIDN'T COME FROM ACTIVATION MAIL//DIRECT ACCESS ATTEMPT
if ($_SESSION['wl'] != 1)
{
	//REDIRECTING TO ERROR PAGE//OUTPUT
	header ("location: ../error_fi/error_videos.php");
}//USER DIDN'T COME FROM ACTIVATION MAIL//DIRECT ACCESS ATTEMPT
		
	//USER CAME FROM AUTHENTICATION
	if ($_SESSION['wl'] == 1)
	{
		//SESSION VAR
		$_SESSION['wl'] = 0;
		
		//REDIRECTED TO LOGIN PAGE//OUTPUT 03
		echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
		
	}
	//USER DIDN'T COME FROM AUTHENTICATION
	else
	{
		//ERROR PAGE//OUTPUT 04
		header ("location: ../error_fi/error_videos.php");
	}
?>		
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 00 -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 01 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 02 -->
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
	<div class="content" style="direction:rtl;text-align:center;">
		<!-- HEADER -->
		<h1 style="margin:0px auto;">החשבון הופעל בהצלחה</h1>
		
		<!-- HORIZONTAL LINE -->
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<!-- LINE BELOW HEADER -->
		<div class="user">
			<h4 id="c" style="margin:0px auto;">מיד תועבר/י לדף התחברות</h4> 
		</div>
	</div>
<script>
$("#c").click(function(){
	//REDIRECTED TO LOGIN PAGE//OUTPUT 03
	window.location.replace("../../login/example_cleveland_l_videos.php");
});
</script>
</body>