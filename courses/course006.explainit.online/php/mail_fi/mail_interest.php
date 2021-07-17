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


//VARS
$course_number_="006";

//FUNCTIONS

//DATABASE//DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['from_1_st_time'] == 1 )
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
	$S_interst_name = $con->real_escape_string($_POST['user_name']);
	$S_interst_phone = $con->real_escape_string($_POST['phone']);
	$S_interst_mail = $con->real_escape_string($_POST['mail']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$con_tent=$S_interst_name." ".$S_interst_phone." ".$S_interst_mail;	
	
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
	$sql = "INSERT INTO U_videos_INTEREST (NAME,PHONE,MAIL,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE) VALUES ('$S_interst_name','$S_interst_phone','$S_interst_mail','$date_login','$login_time','$logout_time','$date_logout')";
	$query_1 = mysqli_query($con,$sql);
	
	//REDIRECT TO HOMEPAGE//OUTPUT 03
	echo '<script>setTimeout(function(){$("#c").click();}, 4000);</script>';
	sleep(2);

	//REPORT MAIL//OUPTUT 04
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס ".$course_number_." - מתעניין/ת חדש/ה";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
		$message .= '<h4>שם:</h4>';
		$message .= '<h4>'.$S_interst_name.'</h4>';
		$message .= '<h4>מייל:</h4>';
		$message .= '<h4>'.$S_interst_mail.'</h4>';
		$message .= '<h4>טלפון:</h4>';
		$message .= '<h4>'.$S_interst_phone.'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
		

	//SETTING SESSION VAR TO 0
	$_SESSION['from_1_st_time'] = 0;
}
else//TRYING TO GET IN WITH NO SESSION VAR
{
	//REPORT MAIL//OUPTUT 05
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס ".$course_number_." - MAIL INTEREST - Direct Access Attempt";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
		$message .= '<h4>IP:</h4>';
		$message .= '<h4>'.$_SERVER["REMOTE_ADDR"].'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
		

	
	//ERROR PAGE//OUTPUT 06
	header ('location: ../error_fi/error_videos.php');
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
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 02 -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style>	
/* BACKGROUND */
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
</style>	
</head>
<body>
<!-- CONTENT DIV 01 -->
<div style="direction:rtl;text-align:center;">
	
	<!-- TEXT -->
	<h1 id="c" style="margin-bottom:0px;">קיבלנו</h1>
	
	<!-- EMOJI -->
	<i class="em em-trophy"></i>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<!-- TEXT -->	
	<h4 style="margin:0px 0px 5px 0px;">נדבר בקרוב</h4>
</div><!-- CONTENT DIV 01 -->

<script>
$("#c").click(function(){
	//REDIRECT TO HOMEPAGE//OUTPUT 03
	window.location.replace("../../index.php");
});
</script>
</body>