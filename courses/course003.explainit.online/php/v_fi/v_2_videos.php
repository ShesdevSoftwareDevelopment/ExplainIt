<?php
//SESSION START
	session_start();

//ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

//SSL REDIRECT//OUTPUT 00
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}

//FUNCTIONS
	function valid($check)
	{
		//CHECKING LENGTH
		if (mb_strlen($check)>=8)
		{
			return TRUE;
		}	
	}
	
//SESSION VARS
	if(!isset($_SESSION['message_1']))
	{
		$_SESSION['message_1']='';
	}
		
//DATABASE//CONNECTING//DATA
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
	
//WE'RE CONNECTED
//METHOD POST
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//SANITIZING DATA
	$Pa_name = $con->real_escape_string($_POST['pass_word']);
	$Pa_2_name = $con->real_escape_string($_POST['pass_word_2']);
	
	//PASSWORDS MATCH
	if($Pa_name==$Pa_2_name)
	{
		//PASSWORD LONG ENOUGH
		if (valid($Pa_name))
		{	
			//SESSION VAR
			$e_ = $_SESSION['d_1'];
			$P_h_ = $_SESSION['d_2'];
			$z_1 = 1;
			$_SESSION['d_1'] = 0;
			$_SESSION['d_2'] = 0;
			
			//RETRIEVING 
			$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_' AND U_AP = '$z_1'";
			$query = mysqli_query($con,$sql);
			$row = mysqli_fetch_array($query,MYSQLI_ASSOC);		
			
			//NO SUCH MAIL
			if(mysqli_num_rows($query) == 0)
			{
				//SESSION VAR
				$_SESSION['message_1']="החלפת סיסמה נכשלה";
					
				//ERROR PAGE//OUTPUT 01
				header("location: ../error_fi/error_videos.php");
			}//NO SUCH MAIL
			
			//MAIL FOUND
			else
			{
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
				
				//SESSION VARS
				$_SESSION['a_p']='av/1.png';
				$_SESSION['u_n']=$row['U_N'];
				
				//UPDATING
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
				
				//QUERY SUCCESSFUL, REDIRECT TO WELCOME PAGE
				if($query)
				{
					//SESSION VARS
					$_SESSION['message_1']="החלפת סיסמה מוצלחת";
					$_SESSION['message_2']="אנא התחבר עם הסיסמה החדשה";
					
					//CONFIRMATION MAIL//OUTPUT 02
					
					/* HTML MAIL WITH PHP *//* https://css-tricks.com/sending-nice-html-email-with-php/ */
					
					//ATTRIBUTES
					$t=$E_mail;
					$s="Explainit Online - קורס 003 - החלפת סיסמה בהצלחה";
					
					//HEADERS
					$headers = "From: registration@explainit.online\r\n";
					$headers .= "Reply-To:registration@explainit.online\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					
					//MESSAGE
					$message = '<html lang="iw" dir="rtl"><body>';
					$message .= '<div style="width:100%;margin:auto;text-align:center;direction:rtl;">';
					$message .= '<h4>הי,</h4><h4>אם לא את/ה החלפת סיסמה, אנא צור/י איתנו קשר ב-registration@explainit.online.
					</h4></div>';
					$message .= "</body></html>";
					
					//SENDING
					mail($t,$s, $message, $headers);
			
					
					//REPORT MAIL//OUTPUT 03
					
					//ATTRIBUTES
					$f = "registration@explainit.online";
					$f_1="Explainit Online - קורס 003 - החלפת סיסמה בהצלחה";
							
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
					
					//SESSION VAR
					$_SESSION['reco'] = 1;
					
					//WELCOME PAGE//OUTPUT 04
					header ("location: reconnect_videos.php");
				}//QUERY SUCCESSFUL, REDIRECT TO WELCOME PAGE
			
				//QUERY UNSUCCESSFUL, REDIRECT TO ERROR PAGE
				else
				{
					//SESSION VAR
					$_SESSION['message_1']="הרשמה לא מוצלחת";
					
					//ERROR PAGE//OUTPUT 05
					header("location: ../error_fi/error_videos.php");
				}//QUERY UNSUCCESSFUL, REDIRECT TO ERROR PAGE
			}//MAIL FOUND
		}//PASSWORD LONG ENOUGH
		
		//PASSWORD NOT LONG ENOUGH
		else
		{
			//SESSION VAR
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>סיסמה לא ארוכה מספיק</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='a_1' style='margin:2px auto;'>צריך מינימום 8 אותיות ומספרים</h4>";
			
		}   
	}//PASSWORDS MATCH
	
	//PASSWORDS DON'T MATCH
	else
	{
		//SESSION VAR
		$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>הסיסמאות לא מתאימות</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
		
	}//PASSWORDS DON'T MATCH
}//METHOD POST

//METHOD NOT POST
else
{
	//SESSION VAR
	$_SESSION['message_1']="משהו לא עובד, אנא נסה שוב או צור איתנו קשר ב<br><h4 id='c' style='margin:2px auto;'>registration@explainit.online</h4>";
	
	//ERROR PAGE//OUTPUT 06
	header ("location: ../error_fi/error_videos.php");
}//METHOD NOT POST

?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 07 -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 08 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
			
	<!-- CSS --><!-- OUTPUT 09 -->
	<link rel="stylesheet" href="../../css/2.css">
		
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
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
		background: #A9014B url(../../css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 10 */
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

/* TEMPLATE */

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
</head>

<body>
<!-- TEXT DIV -->
<div style="text-align:center;width:100%;direction:rtl;">
	
	<!-- SESSION VAR -->
	<?=$_SESSION['message_1'] ?>
	
	<!-- SELF POST --><!-- OUTPUT 11 -->
	<form action="v_2_videos.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה חדשה" name="pass_word" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה חדשה שוב" name="pass_word_2" autocomplete="new-password" required><br>
		
		<!-- HORIZONTAL LINE -->
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="שלח/י" name="register">
		</div>
	</form><!-- SELF POST -->
</div><!-- TEXT DIV -->
</body>