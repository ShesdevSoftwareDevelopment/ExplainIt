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
	if(!isset($_SESSION['message_1']))
	{
		$_SESSION['message_1']='';
	}
	//$_POST['pass_word'] = "";
	
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
	$Pa_name = $con->real_escape_string($_POST['pass_word']);
	$Pa_2_name = $con->real_escape_string($_POST['pass_word_2']);
	
	if($Pa_name==$Pa_2_name)//Passwords match
	{
		if (valid($Pa_name))//Password long enough
		{	
			$e_ = $_SESSION['d_1'];
			$P_h_ = $_SESSION['d_2'];
			$z_1 = 1;
			
			$_SESSION['d_1'] = 0;
			$_SESSION['d_2'] = 0;
			
			//retrieving
			$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_' AND U_AP = '$z_1'";
			$query = mysqli_query($con,$sql);
			$row = mysqli_fetch_array($query,MYSQLI_ASSOC);		
			
			$U_name = $row['U_N'];
			$E_mail = $row['U_M'];
			$P_ass = md5($con->real_escape_string($_POST['pass_word']));
			$P_h = $con->real_escape_string(md5(rand(0,1100)));
			
			//$A_path = $con->real_escape_string('av/'.$_FILES['image_1']['name']);
								
			//Securing
			$bytes_0 = bin2hex(random_bytes(5));
			$bytes_1 = bin2hex(random_bytes(5));
			$bytes_2 = bin2hex(random_bytes(5));
			$bytes_3 = bin2hex(random_bytes(5));
			$bytes_4 = bin2hex(random_bytes(5));
			
			$bytes_4 = md5($bytes_4);
			
			$p_0 = $bytes_1.$bytes_4.$bytes_0;
			$p_2 = md5($p_0);
			
			$p_3 = $bytes_2.$bytes_4.$bytes_3;
			$p_4 = md5($p_3);
			
			$p_5 = $bytes_0.$bytes_4.$bytes_4;
			$p_6 = md5($p_5);
			
			$p = $bytes_0.$P_ass.$bytes_2;
			$p_1 = md5($p);
			
			$_SESSION['a_p']='av/1.png';
			//$_SESSION['u_n']=$U_name;
						
			$_SESSION['u_n']=$row['U_N'];
			
			$sql = "UPDATE U_videos SET U_P = '$p_1',U_Z='$p_2',U_A='1.png',U_E='$bytes_2',U_U='$bytes_0',U_V='$bytes_1',U_X='$bytes_3',U_Y='$p_6',U_T='$p_4',U_IO='$P_h' WHERE U_N='$U_name' AND U_M='$E_mail'";
			$query = mysqli_query($con,$sql);
			//var_dump ($query);				
			/*
			//debugging
				
				echo '<pre style="background:white;color:black;margin-top:3px;text-align:center;border:2px black solid;">';
				//8echo '<h3 style="margin:0px auto;"><u>b_0:</u></h3>';
				//8var_dump($bytes_0);
				//8var_dump($bytes_1);
				//8var_dump($bytes_2);
				//8var_dump($bytes_3);
				//8var_dump($bytes_4);
				//8echo '<h3 style="margin:0px auto;"><u>query:</u></h3>';
				//8var_dump($query);
				//8echo '<h3 style="margin:0px auto;"><u>con:</u></h3>';
				//8var_dump($con);
				echo '</pre>';
			*/
			
			//if query successful, redirect to welcome page
			if($query)
			{
				$_SESSION['message_1']="החלפת סיסמה מוצלחת";
				$_SESSION['message_2']="אנא התחבר עם הסיסמה החדשה";
				//header("location: http://explainit.online/s1/s8_f/wl.php");
				
				//MAIL//OUTPUT
				//confirmation mail
				$t=$E_mail;
				$s="החלפת סיסמה בהצלחה explainit.online";
				$m='אם לא אתה החלפת סיסמה, אנא צור איתנו קשר ב-registration@explainit.online.';				
				$m = wordwrap($m,70);
				$e = "registration@explainit.online";
				/*$headerFields = array(
				"From: {$visitor_email}",
				"MIME-Version: 1.0",
				"Content-Type: text/html;charset=utf-8");
				*/
				mail($t,$s,$m,"FROM:".$e."\r\n"."Content-Type: text/html;charset=utf-8");
				
				//MAIL//OUTPUT
				$f="registration@explainit.online";
				$f_1="".$_SESSION['u_n']." החליף סיסמה בהצלחה";
				$f_2=$t;
				mail($f,$f_1,$f_2,"FROM:".$e."\r\n"."Content-Type: text/html;charset=utf-8");
				
				$_SESSION['reco'] = 1;
				
				//OUTPUT
				header ("location: reconnect_videos.php");
			}
			else
			{
				$_SESSION['message_1']="הרשמה לא מוצלחת";
				
				//OUTPUT
				header("location: ../error_fi/error_videos.php");
			}
		}//Password not long enough
		else
		{
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>סיסמה לא ארוכה מספיק</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='a_1' style='margin:2px auto;'>צריך מינימום 8 אותיות ומספרים</h4>";
			//echo '<script>setTimeout(function(){$("#a_1").click();}, 0001);</script>';
		}   
	}//Passwords don't match
	else
	{
		$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>הסיסמאות לא מתאימות</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
		//echo '<script>setTimeout(function(){$("#a_1").click();}, 0001);</script>';
	}
}//POST
else
{
	$_SESSION['message_1']="משהו לא עובד, אנא נסה שוב או צור איתנו קשר ב<br><h4 id='c' style='margin:2px auto;'>registration@explainit.online</h4>";
	
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