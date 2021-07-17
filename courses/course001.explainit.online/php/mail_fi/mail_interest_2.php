<?php
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

//FUNCTIONS

//DATABASE//DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['visit_data'] == 1 )
{
	//CONNECTING//DATA
	//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
		include "../test_fi/test_po_7_2.php";
		
		//GET DB DETAILS
		$new_path = 'test_01';
		$db_details = getfile($new_path,12);
		
		//CONNECTING//DATABASE//DATA
	
		$host = $db_details[0];
		$username = $db_details[1];
		$password = $db_details[2];
		$db = $db_details[3];

	//CREATING CONNECTION
	$con = mysqli_connect($host, $username, $password,$db);
	
	//CHECKING CONNECTION
	if($con)
	{
		//echo '<i class="fa fa-check-square-o" style="font-size:24px;color:purple;"></i>';
		//echo 'connection ok';
	}
	else
	{
		die('Could not connect: ' . mysqli_error($con));
	}
		
	//SELECTING DATABASE
	mysqli_select_db($con, $db_details[3]); 
	
	//ENABLING HEBREW
	mysqli_query($con,"SET character_set_client=utf8mb4");
	mysqli_query($con,"SET character_set_connection=utf8mb4");
	mysqli_query($con,"SET character_set_database=utf8mb4");
	mysqli_query($con,"SET character_set_results=utf8mb4");
	mysqli_query($con,"SET character_set_server=utf8mb4");
	
	//SETTING TIME	
	$sql_Time = "SET time_zone = '+03:00';";
    $query = mysqli_query($con,$sql_Time);
	
	//SANITIZING
	$query = $_SERVER['QUERY_STRING'];
	$referer = $_SERVER['HTTP_REFERER'];
	$ip_address=$_SERVER['REMOTE_ADDR'];
		
	//UPDATING//UPDATING LOGS
	//LOGIN TIME
	date_default_timezone_set('Asia/Jerusalem');
	$login_time = time();
	$date_login = date('m/d/Y h:i:s a', time());
	
	//LOGOUT TIME
	date_default_timezone_set('Asia/Jerusalem');
	$logout_time = time()+(3600);//1 HOUR LATER//? NEEDED
	$date_logout = date('m/d/Y h:i:s a', $logout_time);
		
	//QUERIE
	$sql = "INSERT INTO U_videos_DATA (IP,REFERER,LOGIN_DATE,LOGIN_TIME) VALUES ('$ip_address','$referer','$date_login','$login_time')";
	$query_1 = mysqli_query($con,$sql);
	
	//REPORT MAIL//OUPTUT 04
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס 001 - מבקר/ת חדש/ה";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
		$message .= '<h4>מפנה:</h4>';
		$message .= '<h4>'.$referer.'</h4>';
		$message .= '<h4>IP:</h4>';
		$message .= '<h4>'.$ip_address.'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
}
else//TRYING TO GET IN WITH NO SESSION VAR
{
	//REPORT MAIL//OUPTUT 05
		$f = "registration@explainit.online";
		$f_1="XO_001 - MAIL INTEREST 02 - Direct Access Attempt";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
		$message .= '<h4>מפנה:</h4>';
		$message .= '<h4>'.$_SERVER['HTTP_REFERER'].'</h4>';
		$message .= '<h4>IP:</h4>';
		$message .= '<h4>'.$_SERVER['REMOTE_ADDR'].'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
		
	//REDIRECT TO HOMEPAGE//OUTPUT
	echo '<script>setTimeout(function(){$("#c").click();}, 4000);</script>';
	sleep(2);
}
?>
<html>
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
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 02 -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style>
/* COLORS */

body 
{
	color:white;
	background-color:black;
}

/* FONTS */

*	
{
	font-family: 'Secular One', sans-serif;
}
</style>
</head>
<body>
<div id="c" style="display:none;"></div>
<script>
$("#c").click(function(){
	//REDIRECT TO HOMEPAGE//OUTPUT 03
	window.location.replace("../index.php");
});
</script>
</body>
</html>