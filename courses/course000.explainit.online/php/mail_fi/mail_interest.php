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

// Functions

//DATABASE	
// Data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['from_1_st_time'] == 1 )
{
	// Connecting
	// data
	$host = 'localhost';
	$username = 'elad189g_xo_course001';
	$password = 'Wonderfull5600';
	$db = 'elad189g_xo_course001_us';
	
	// creating Connection
	$con = mysqli_connect($host, $username, $password,$db);
	
	// checking Connection
	if($con)
	{
		//echo '<i class="fa fa-check-square-o" style="font-size:24px;color:purple;"></i>';
		//echo 'connection ok';
	}
	else
	{
		die('Could not connect: ' . mysqli_error($con));
	}
		
	// Selecting Database
	mysqli_select_db($con, "elad189g_ex_us"); 
	
	// Enabling Hebrew
	mysqli_query($con,"SET character_set_client=utf8mb4");
	mysqli_query($con,"SET character_set_connection=utf8mb4");
	mysqli_query($con,"SET character_set_database=utf8mb4");
	mysqli_query($con,"SET character_set_results=utf8mb4");
	mysqli_query($con,"SET character_set_server=utf8mb4");
	
	// Setting Time	
	$sql_Time = "SET time_zone = '+03:00';";
    $query = mysqli_query($con,$sql_Time);
	
	//SANITIZING
	
	$S_interst_name = $con->real_escape_string($_POST['user_name']);
	$S_interst_phone = $con->real_escape_string($_POST['phone']);
	$S_interst_mail = $con->real_escape_string($_POST['mail']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$con_tent=$S_interst_name." ".$S_interst_phone." ".$S_interst_mail;	
	
	//UPDATING
	//UPDATING LOGS
	//LOGIN TIME
	date_default_timezone_set('Asia/Jerusalem');
	$login_time = time();
	$date_login = date('m/d/Y h:i:s a', time());
							
	//LOGOUT TIME
	date_default_timezone_set('Asia/Jerusalem');
	$logout_time = time()+(3600);//1 hour later
	$date_logout = date('m/d/Y h:i:s a', $logout_time);
	
	//QUERIE
	$sql = "INSERT INTO U_videos_INTEREST (NAME,PHONE,MAIL,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE) VALUES ('$S_interst_name','$S_interst_phone','$S_interst_mail','$date_login','$login_time','$logout_time','$date_logout')";
	$query_1 = mysqli_query($con,$sql);
	
	echo '<script>setTimeout(function(){$("#c").click();}, 3000);</script>';
	sleep(2);

	//MAIL	
	//REPORT MAIL
	$e = "registration@explainit.online";		
	$f="registration@explainit.online";
	$f_1="מתעניין/ת חדש/ה";
	$f_2=$con_tent;
	mail($f,$f_1,$f_2,"FROM:".$e);

	//SETTING SESSION VAR TO 0
	$_SESSION['from_1_st_time'] = 0;
}
else//TRYING TO GET IN WITH NO SESSION VAR
{
	//REPORT MAIL
	$e = "registration@explainit.online";		
	$f="registration@explainit.online";
	$f_1="מישהו מנסה להכנס לדף mail_interest ישירות";
	$f_2="";
	mail($f,$f_1,$f_2,"FROM:".$e);
	
	//OUTPUT
	header ('location: ../error_fi/error_videos.php');
}
?>
<body>
<div style="direction:rtl;text-align:center;">
	<h1 id="c" style="margin-bottom:0px;">קיבלנו</h1>
	<i class="em em-trophy"></i>
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
		
	<h4 style="margin:0px 0px 5px 0px;">נדבר בקרוב</h4>
</div>

<script>
$("#c").click(function(){
	//OUTPUT
	window.location.replace("../../index.php");
});
</script>
</body>