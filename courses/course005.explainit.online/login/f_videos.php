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

//VARS
$course_number_="005";

//FUNCTIONS//SESSION VARS
	$_SESSION['message_1']='חידוש סיסמה';
	$_SESSION['m'] = 0;
	$_SESSION['m_1'] = 0;

//DATABASE//CONNECTING//DATA
	//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
		include "../php/test_fi/test_po_7.php";
		
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
	
//CONNECTING END

//SELF POST
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//SANITIZING
	$e_ = $con->real_escape_string($_POST['e']);
			
	//RETREIVING DATA
	$sql = "SELECT * FROM U_videos WHERE U_M = '$e_'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
		
	if(mysqli_num_rows($query) == 0)//NO SUCH MAIL
	{
		//USER TRIED INSERTING MAIL LESS THAN 3 TIMES
		if ($_SESSION['count']<3)
		{
			//SESSION VAR
			$_SESSION['message_1']="אין מייל כזה<br><h4 id='c' style='margin:2px auto;'>רוצה לנסות שוב?</h4>";
			$_SESSION['count']++;
		}
		//USER TRIED INSERTING MAIL MORE THAN 3 TIMES
		else
		{
			$_SESSION['message_1']="אין מייל כזה<br><h4 id='c' style='margin:2px auto;'>את/ה מועבר/ת חזרה לדף הבית</h4>";
			$_SESSION['m_1'] = 1;
			
			//ERROR PAGE//OUTPUT 00
			header ("location: ../php/error_fi/error_videos.php");
		}
	}
	else//MAIL FOUND
	{
		//SESSION VAR
		$_SESSION['message_1']="מייל חידוש סיסמה נשלח בהצלחה<br><h4 id='d' style='margin:2px auto;'></h4>בדוק/בדקי את המייל";	
		$_SESSION['m']= 1;
		
		//MAIL//PASSWORD REPLACEMENT CONFIRMATION MAIL//OUTPUT 01
		$_SESSION['u_n'] = $row['U_N'];
		$t=$row['U_M'];
		$P_h=$row['U_IO'];
		
		/* HTML MAIL WITH PHP *//* https://css-tricks.com/sending-nice-html-email-with-php/ */
						
		//CONFIRMATION MAIL//
		
		//ATTRIBUTES
		$s="Explainit Online - קורס ".$course_number_." - החלפת סיסמה";
		
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;direction:rtl;">';
		$message .= '<h4>הי,</h4><h4>במידה ולא את/ה ביקשת להחליף סיסמה, אל תלחץ/י על הכפתור וצור/י איתנו קשר ב-registration@explainit.online.
		</h4>';
		//<a href="https://www.course002.explainit.online/php/v_fi/v_1_videos.php?e='.$t.'&h='.$P_h.'">
		$message .= '<div style="width:50%;margin:auto;">
						<a href="https://course'.$course_number_.'.explainit.online/php/v_fi/v_1_videos.php?e='.$t.'&h='.$P_h.'">
							<button style="width:100%;
										border-radius: 5px;
										-moz-border-radius: 5px;
										-webkit-border-radius: 5px;
										display: inline-block;
										color: white;
										padding: 5px 10px 5px;
										white-space: nowrap;
										text-decoration: none;
										cursor: pointer;
										background: #A9014B;
										border-style: none;
										text-align: center;
										overflow: visible;"
							><b>החלפה</b></button>
						</a>
					</div>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($t,$s, $message, $headers);
			

		//MAIL//REPORT MAIL//OUTPUT 02
		//ATTRIBUTES
		$f = "fiveminutes003@gmail.com, registration@explainit.online";
		$f_1="XO - ".$course_number_." - CHANGE PASS REQUEST";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
		$message .= '<h4>מייל:</h4>';
		$message .= '<h4>'.$t.'</h4>';
		$message .= '<h4>IP:</h4>';
		$message .= '<h4>'.$_SESSION['u_n'].'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
			
		//E-MAIL AUTHENTICATION PAGE//OUTPUT 03
		header ("location: ../php/v_fi/v_videos.php");
	}//MAIL FOUND
}//SELF POST

//USER CAME FROM EXAMPLE_L_VIDEOS_4.PHP
if(strpos($_SERVER["HTTP_REFERER"], 'example_cleveland_l_videos_4.php') == true)
{
	$_SESSION['L_4'] = 1;
}
?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- TITLE -->
	<title>פיזיקה לבגרות | חשמל ומגנטיות | שכחתי סיסמה</title>
	
	<!-- DESCRIPTION -->
	<meta name="description" content='שכחתי סיסמה'>
		
	<!-- FAVICON --><!-- OUTPUT 04 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
		
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 05 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 06 -->
	<link rel="stylesheet" href="../css/2.css">
	
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
		background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 07 */
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

/* TEMPLATE */

body
	{
		/* Background pattern from Toptal Subtle Patterns */
		background-image:url(../img/background/grey_wash_wall.png);
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
<!-- PASSWORD CHANGE DIV -->
<div id="div_1" style="direction:rtl;text-align:center;width:100%;">
	<!-- TEXT -->
	<h1 style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<!-- TEXT -->
	<h4 style="margin:0px auto;">הכנס/י את המייל שנרשמת איתו לאתר</h4>			
	
	<!-- PASSWORD CHANGE FORM --><!-- OUTPUT 08 -->
	<form action="f_videos.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input style="margin:4px auto;padding:2px;text-align:center;width:200px;" type="text" placeholder="מייל" name="e" required><br>
		
		<!-- SUBMIT -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="שלח" name="register">
		</div>
	</form><!-- PASSWORD CHANGE FORM -->
</div><!-- PASSWORD CHANGE DIV -->
</body>