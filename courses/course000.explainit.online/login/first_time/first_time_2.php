<head>
<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- favicon --><!-- OUTPUT -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- IOS PHONES -->
	<meta name="format-detection" content="telephone=no">
	
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- General stuff -->
			<!-- Emoji CSS -->
			<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
			
			<!-- Jquery -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style>
/* BUTTON *//*http://jeromejaglale.com/doc/css/pretty_button*/	
		.button 
		{
			/*font: bold 13px "Helvetica Neue", Helvetica, Arial, clean, sans-serif !important;*/
			text-shadow: 0 -1px 1px rgba(0,0,0,0.25), -2px 0 1px rgba(0,0,0,0.25);
			border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.5);
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.5);
			display: inline-block;
			color: white;
			padding: 5px 10px 5px;
			white-space: nowrap;
			text-decoration: none;
			cursor: pointer;
			background: #A9014B url(../../css/button_overlay.png) repeat-x scroll 0 0;/*OUTPUT*/
			border-style: none;
			text-align: center;
			overflow: visible;
		}
		
		.button:hover,
		.button:focus 
		{
			background-position: 0 -50px;
			color: white;
		}
		
		.button:active 
		{
			background-position: 0 -100px;
			-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.7);
			-webkit-box-shadow: none;
		}
	
/* CLASSES */
	.responsive_input_4
	{
		width:96%;
		height:36px;
		margin:4px 2px;
		padding:6px;
		font-size:16px;
	}
	
/* @ MEDIA */
	@media only screen and (max-width: 500px)
	{
		.responsive_input_4
		{
			width:96%;
			height:36px;
			margin:4px 2px;
			padding:6px;
			font-size:16px;
		}
	}
</style>
</head>
<?php
session_start();

// display errors
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
// SSL
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
?>

<body>

<div style="direction:rtl;text-align:center;">
	<h1 style="margin-bottom:0px;">רוצה אתר כזה?</h1>
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<div style="width:75%;margin:auto;text-align:center;"> 
		
		<!-- BUTTON --><!-- OUTPUT -->
		<div style="width:75%;margin:auto;">
			<a href="tel:050-8523270" rel="nofollow">
				<input class="responsive_input_4 button" style="width:100%;" type="submit" value="050-8523270" name="register">
			</a>
		</div>
    </div>	
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<div style="width:100%;margin:auto;">
		<h4 style="margin:4px auto;padding:2px;font-size:16px;">או השאר/י פרטים ונחזור אליך</h4>
	</div>
</div>

<div style="direction:rtl;text-align:center;">
	
	<!-- OUTPUT -->
	<form action="../../php/mail_fi/mail_interest.php" method="post" enctype="multipart/form-data" autocomplete="on" style="margin-bottom:0px;">
		<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="שם" name="user_name" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="טלפון" name="phone" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="email" placeholder="מייל" name="mail"><br>
				
		<div>
			<i id="p" class="em em-crown"></i>
		</div>
		<input style="margin:4px auto;padding:2px;" type="submit" value="שלח/י" name="register">
	</form>
</div>
</body>
<?php
	
	//SETTING SESSION VAR	
	$_SESSION['from_1_st_time'] = 1;
	
	//SLEEPING
	sleep(2);
?>