<?php
session_start();
// display errors on
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	
// SSL
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

//	Functions
	function valid($check)
	{
		//checking length
		if (mb_strlen($check)>=8)
		{
			return TRUE;
			
			//checking not all upper case or lower case
			if(!ctype_upper($check) && !ctype_lower($check))
			{
				//$_SESSION['test'] = 0;
				//return TRUE;
				//return mb_strlen($check);
				//return $check;
			}
		}	
	}
//	Vars
	$_SESSION['message_1']='הי, <br> כאן מאשרים החלפת סיסמה';
	$_SESSION['m_3'] = 0;
			
	//DATABASE
	// connecting
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
	
// Connecting End

if (isset($_GET['e']) && !empty($_GET['e']) AND isset($_GET['h']) && !empty($_GET['h']))
{
	// Sanitizing
	$e_ = $con->real_escape_string($_GET['e']);
	$P_h_ = $con->real_escape_string($_GET['h']);
	$_SESSION['d_1'] = $e_;
	$_SESSION['d_2'] = $P_h_;
	$z = 0;
	$z_1 = 1;
		
	//retrieving
	$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_' AND U_AP = '$z_1'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);		
		
	//if(mysqli_num_rows($query) > 0)
	if(mysqli_num_rows($query) == 0)
	{
		$_SESSION['message_1']="משהו לא עובד, אנא נסה שוב או צור איתנו קשר ב-registration@explainit.online<br><h4 id='c' style='margin:2px auto;'></h4>";
		$_SESSION['m_3'] = 1;
		//echo '<script>setTimeout(function(){$("#c").click();}, 4000);</script>';
		
		//OUTPUT
		header ("location: ../error_fi/error_videos.php");
	}
	else
	{
		$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>אנא בחר/י סיסמה חדשה</h1><div style='width:50%;margin:auto;'><hr></div>";	
	}//u_m
}// c_1
else
{
	$_SESSION['message_1']="משהו לא עובד, אנא נסה שוב או צור איתנו קשר ב<br><h4 id='c' style='margin:2px auto;'>registration@explainit.online</h4>";
	//echo $_SESSION['message_1'];
	//echo '<script>setTimeout(function(){$("#c").click();}, 4000);</script>';
	
	//OUTPUT
	header ("location: ../error_fi/error_videos.php");
}

?>
<head>
<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- OUTPUT -->
	<!-- favicon -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- OUTPUT -->
	<!-- APPLE TOUCH ICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- OUTPUT -->
	<!-- CSS -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- General stuff -->
		
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

<body>
<div style="text-align:center;width:100%;direction:rtl;">
	<?=$_SESSION['message_1'] ?>
	
	<!-- OUTPUT -->
	<form action="v_2_videos.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה חדשה" name="pass_word" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה חדשה שוב" name="pass_word_2" autocomplete="new-password" required><br>
		
		<!-- HORIZONTAL LINE -->
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="שלח" name="register">
		</div>
	</form>
</div>

<script>
$("#c").click(function(){
	//OUTPUT
	window.location.replace("../../index.php");
	});
</script>
</body>