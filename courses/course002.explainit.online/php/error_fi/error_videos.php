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

//SESSION VAR
	$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>משהו לא עובד</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>או שיכול להיות שהגיע הזמן להתחבר מחדש.<br>כל כמה זמן המערכת מתנתקת אוטומטית. <br>אנא נסה להתחבר שוב.<br><br>במידת הצורך צור איתנו קשר ב-<br>registration@explainit.online</h4>";
?>
<head>
<!-- ENCODING  -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 00 -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 01 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 02 -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- JQUERY -->
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
		background: #A9014B url(../../css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 03 */
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

<body>
	<!-- TEXT -->
	<div style="text-align:center;width:100%;direction:rtl;">
		<?=$_SESSION['message_1'] ?>
	</div>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
		
	<!-- REDIRECT TO LOGIN DIV --><!-- OUTPUTS 04 -->
	<div style="width:50%;margin:auto;padding:6px;">
		
		<!-- REDIRECT TO LOGIN --><!-- OUTPUT 04 -->
		<a href="../../login/example_cleveland_l_videos.php">
			<input class="responsive_input_4 button" style="width:100%;font-size:16px;" type="submit" value="להתחברות מחדש" name="register">
		</a>
	</div><!-- REDIRECT TO LOGIN DIV -->
</body>