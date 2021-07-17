<head>
<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
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

// Vars
//$_SESSION['message_1']="משהו לא עובד, <br>אנא נסה שוב או צור איתנו קשר ב<br><h4 id='c' style='margin:2px auto;'>registration@explainit.online</h4>";
$_SESSION['message_1']="את/ה מחובר/ת ממכשיר אחר<h4 id='c' style='margin:2px auto;'>או מחלון דפדפן אחר אם את/ה על מחשב.<br> אנא התנתק/י מהמכשיר האחר ונסה/י שוב או צור/י איתנו קשר ב-<br>registration@explainit.online</h4>";
?>

<body>
<div style="text-align:center;width:100%;direction:rtl;">
	<h1 style="margin-bottom:0px;">את/ה מחובר/ת ממכשיר אחר </h1><h4 style="margin:0px auto;">או מחלון דפדפן אחר אם את/ה על מחשב</h4>
</div>

	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
<div style="direction:rtl;text-align:center;">
	<h4 style="margin:0px auto;">לניתוק המכשיר האחר הכנס/י את המייל והסיסמה איתם נרשמת לאתר</h4>
	<i class="em em-writing_hand"></i>
	
	<!-- OUTPUT -->
	<form action="../../login/example_cleveland_l_videos_2.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מייל" name="user_name" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" required><br>
		<div style="font-size:14px;"><!-- OUTPUT --><a href="../../login/f_videos.php">שכחתי סיסמה</a></div>
		
		<div>
			<i id="p" class="em em-airplane"></i>
		</div>
				
		<!-- BUTTON --><!-- OUTPUT -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="ניתוק מכשיר אחר" name="register">
		</div>
	</form>
</div>

</body>