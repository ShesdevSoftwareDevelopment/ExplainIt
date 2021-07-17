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
		
//	Vars
	$_SESSION['message_1']='חידוש סיסמה';
	$_SESSION['m'] = 0;
	$_SESSION['m_1'] = 0;

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

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// Sanitizing
	$e_ = $con->real_escape_string($_POST['e']);
			
	//retrieving
	$sql = "SELECT * FROM U_videos WHERE U_M = '$e_'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
		
	if(mysqli_num_rows($query) == 0)//No such mail
	{
		if ($_SESSION['count']<3)
		{
			$_SESSION['message_1']="אין מייל כזה<br><h4 id='c' style='margin:2px auto;'>רוצה לנסות שוב?</h4>";
			$_SESSION['count']++;
		}
		else
		{
			$_SESSION['message_1']="אין מייל כזה<br><h4 id='c' style='margin:2px auto;'>את/ה מועבר/ת חזרה לדף הבית</h4>";
			$_SESSION['m_1'] = 1;
			
			//OUTPUT
			header ("location: ../php/error_fi/error_videos.php");
		}
	}
	else//Mail found
	{
		$_SESSION['message_1']="מייל חידוש סיסמה נשלח בהצלחה<br><h4 id='d' style='margin:2px auto;'></h4>בדוק/בדקי את המייל";	
		$_SESSION['m']= 1;
		
		//MAIL//OUTPUT
		//confirmation mail
		$_SESSION['u_n'] = $row['U_N'];
		$t=$row['U_M'];
		$P_h=$row['U_IO'];
		$s="החלפת סיסמה explainit.online";
		$m=' הי, במידה ולא אתה ביקשת להחליף סיסמה, אל תלחץ על הלינק וצור איתנו קשר ב-registration@explainit.online.
		אם ביקשת, החלף/י סיסמה בלחיצה על הלינק:
		http://www.course001.explainit.online/php/v_fi/v_1_videos.php?e='.$t.'&h='.$P_h;				
		$m = wordwrap($m,70);
		$e = "registration@explainit.online";
		mail($t,$s,$m,"FROM:".$e."\r\n"."Content-Type: text/html;charset=utf-8");
		
		$f="registration@explainit.online";
		$f_1="".$_SESSION['u_n']." ביקש להחליף סיסמה";
		$f_2=$t;
		mail($f,$f_1,$f_2,"FROM:".$e);
		
		//OUTPUT
		header ("location: ../php/v_fi/v_videos.php");
	
	}//u_m
}// c_1

?>
<head>
<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
		
	<!-- APPLE TOUCH ICON --><!-- OUTPUT -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT -->
	<link rel="stylesheet" href="../css/2.css">
	
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
		background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;/*OUTPUT*/
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
<div id="div_1" style="direction:rtl;text-align:center;width:100%;">
	<h1 style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<h4 style="margin:0px auto;">הכנס/י את המייל שנרשמת איתו לאתר</h4>			
	
	<!-- OUTPUT -->
	<form action="f_videos.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input style="margin:4px auto;padding:2px;text-align:center;width:200px;" type="text" placeholder="מייל" name="e" required><br>
		
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="שלח" name="register">
		</div>
	</form>
</div>

<script>
//MAYBE UNNEEDED
$("#c").click(function(){
	//OUTPUT
	window.location.replace("../index.php");
	});
</script>
</body>