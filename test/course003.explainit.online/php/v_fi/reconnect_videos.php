<?php
//SESSION START
	session_start();

//ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

//SSL REDIRECT//OUTPUT 00
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}
	
	//SESSION VAR SET
	if ($_SESSION['reco'] == 1)
	{
		//SESSION VARS
		$_SESSION['message_1']="את/ה מועבר/ת להתחברות מחדש<h4 id='c' style='margin:2px auto;'>עם הסיסמה החדשה</h4>";
		$_SESSION['reco'] = 0;
		
		//REDIRECTING TO LOGIN PAGE//OUTPUT 01
		echo '<script>setTimeout(function(){$("#c").click();}, 1000);</script>';
	}//SESSION VAR SET
	
	//SESSION VAR ISN'T SET
	else
	{
		//ERROR PAGE//OUTPUT 02
		header("location: ../error_fi/error_videos.php");
	}//SESSION VAR ISN'T SET
?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 03-->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 04 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 05 -->
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
	<div style="text-align:center;width:100%;direction:rtl;">
		<h1 id="c" style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	</div>
<script>
$("#c").click(function(){
	
	//LOGIN PAGE//OUTPUT 01
	window.location.replace("../../login/example_cleveland_l_videos.php");
	});
</script>
</body>