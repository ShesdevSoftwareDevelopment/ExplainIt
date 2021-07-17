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

//DATA
	//USER CAME FROM EXAMPLE_CLEVELAND_L_VIDEOS.PHP
	if ($_SESSION['loggedin'] == 1)
	{
		//SESSION VARS
		$_SESSION["example"] = 1;
		$_SESSION["refresh_count"] = 1;
		$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>אישור המייל עבר בהצלחה.<br>מיד תועבר/י לדף התשלום</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא\"ל</h4>";	
		
		//USER NEEDS TO PAY
		if ($_SESSION['paid'] == 'N')
		{
			//SESSION VAR
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>מיד תועבר/י לדף התשלום</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא\"ל</h4>";	
			
			//REDIRECTED TO PAYMENT//OUTPUT 04
			echo '<script>setTimeout(function(){$("#d").click();}, 4000);</script>';
		}
		//USER PAID
		else
		{		
			//SESSION VAR
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>התחברות מוצלחת</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>את/ה מועבר/ת לאתר</h4>";	
			
			//REDIRECTED TO LOGGEDIN PAGE//OUTPUT 05
			header ("location: ../../logged_in/s10_videos.php");
		}	
	}
	//USER DIDN'T COME FROM EXAMPLE_CLEVELAND_L_VIDEOS.PHP
	else
	{
		//REDIRECTED TO ERROR PAGE//OUTPUT 06
		header ("location: ../error_fi/error_videos.php");
	}
	
?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 01 -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 02 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 03 -->
	<link rel="stylesheet" href="../../css/2.css">
	
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
<div id="d" class="content" style="direction:rtl;text-align:center;">
	<!-- HEADER -->
	<?=$_SESSION['message_1'] ?>
</div>

<script>
$("#d").click(function(){
	//PAYMENT PAGE//OUTPUT 04 
	window.location.replace("https://direct.tranzila.com/ttxxo001cha/");
});
</script>
</body>