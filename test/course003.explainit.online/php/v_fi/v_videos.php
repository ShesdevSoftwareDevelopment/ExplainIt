<?php
session_start();

// display errors
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

// SSL
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

// Functions
		
// Vars
	$_SESSION['message_1']='';

// DATA
//USER PROBABLY CLICKED ON MAIL AND GOT HERE
if (isset($_GET['e']) && !empty($_GET['e']) AND isset($_GET['h']) && !empty($_GET['h']))
{
	//DATABASE
	//CONNECTING
	//DATA
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
	$e_ = $con->real_escape_string($_GET['e']);
	$P_h_ = $con->real_escape_string($_GET['h']);
	$z = 0;
	$z_1 = 1;
		
	//RETRIEVING
	$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_' AND U_AP = '$z'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);	
	
	//SESSION VAR
	$_SESSION['u_n'] = $row['U_N'];
	
	//USER ACOUNT NOT FOUND IN LIST AS AUTHORIZED
	if(mysqli_num_rows($query) == 0)
	{
		//MESSAGE
		$_SESSION['message_1']="החשבון הופעל כבר<br><div style='width:50%;margin:auto;'><hr></div><h4 id='d' style='margin:2px auto;'>את/ה מועבר/ת לדף התחברות</h4>";
		
		//REDIRECTED TO LOGIN PAGE//OUTPUT 03
		echo '<script>setTimeout(function(){$("#d").click();}, 4000);</script>';
		
	}
	//USER ACCOUNT DETAILS FOUND, ACCOUNT ISN'T AUTHORIZED YET
	else
	{
		//UPDATING AUTHORIZATION
		$sql = "UPDATE U_videos SET U_AP = '$z_1' WHERE U_M = '$e_'";
		$query = mysqli_query($con,$sql);
		
		//SESSION VARS
		$_SESSION['active'] = 1;
		$_SESSION['wl'] = 1;
		
		//REPORT MAIL//OUTPUT//MAIL 
		//ATTRIBUTES
		$f = "registration@explainit.online";
		$f_1="003 - הפעלת חשבון";
		$t=$e_;
				
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
		$message .= '<h4 dir="ltr">REGISTERED WITH IP:</h4>';
		$message .= '<h4>'.$_SESSION['u_n'].'</h4>';
		$message .= '<h4 dir="ltr">CURRENT IP:</h4>';
		$message .= '<h4>'.$_SERVER['REMOTE_ADDR'].'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
		
		//REDIRECTED TO WELCOME PAGE//OUTPUT 04
		header ("location: ../wl_fi/wl_videos.php");
	}
}
//DIRECT ACCESS ATTEMPT
else
{
	//USER IS ON SIGN UP SESSION
	if(isset($_SESSION['v_wait']))
	{
		//USER COMPLETED REGISTRATION SUCCESSFULLY
		if ($_SESSION['v_wait'] == 1)
		{
			$_SESSION['message_1']="לחץ/י על הקישור שנשלח במייל<br><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>כדי להפעיל את החשבון</h4>";	
		}
		//USER HASN'T COMPLETED REGISTRATION SUCCESSFULLY
		//OR MAYBE CAME FROM FORGOT PASSWORD PAGE
		else
		{
			//USER CAME HERE FROM FORGOT PASSWORD
			//MEANING HE SIGNED UP BUT HASN"T ACTIVATED ACCOUNT AND REQUESTS TO RETRIEVE PASSWORD
			if($_SESSION['m']== 1)
			{
				$_SESSION['message_1']="לחץ/י על הלינק שנשלח במייל<br><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>כדי להשלים את החלפת הסיסמה</h4>";
			}
			//USER IS ON SIGN UP SESSION AND TRIED DIRECT ACCESS
			//AND DIDN'T COME FROM FORGOT PASSWORD PAGE
			else
			{
				//OUTPUT 05
				header ("location: ../error_fi/error_videos.php");
			}
		}
	}
	//DIRECT ACCESS ATTEMPT NOT ON SIGNUP SESSION OR USER REQUESTED TO
	//CHANGE PASSWORD FROM L_4 PAGE
	else
	{
		//USER REQUESTED TO CHANGE PASSWORD FROM L_4 PAGE
		if($_SESSION['L_4'] == 1)
		{
			//MESSAGE
			$_SESSION['message_1']="לחץ/י על הלינק שנשלח במייל<br><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>כדי להשלים את החלפת הסיסמה</h4>";
		}//USER REQUESTED TO CHANGE PASSWORD FROM L_4 PAGE
		
		//USER DIDN'T COME FROM L_4 PAGE
		else
		{
			//OUTPUT 06
			header ("location: ../../index.php");
		}//USER DIDN'T COME FROM L_4 PAGE
	}
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
	
	<!-- CSS --><!-- OUTPUT 02 -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
		
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style>	
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
	<!-- MESSAGE DIV -->
	<div style="text-align:center;width:100%;">
		<h1 style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	</div>

	<script>
		//OUTPUT 03
		$("#d").click(function(){
			window.location.replace("../../login/example_cleveland_l_videos.php");
		});
	</script>
</body>