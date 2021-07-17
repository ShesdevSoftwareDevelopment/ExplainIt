<?php
//SESSION START
	session_start();

//ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');
	
//SSL//OUTPUT 00
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
	$_SESSION['message_1']='הי, <br> כאן מאשרים החלפת סיסמה';
	$_SESSION['m_3'] = 0;
			
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
	
//WE'RE CONNECTED, CHECKING DATA
//MAIL VARS ARE SET
if (isset($_GET['e']) && !empty($_GET['e']) AND isset($_GET['h']) && !empty($_GET['h']))
{
	//SANITIZING
	$e_ = $con->real_escape_string($_GET['e']);
	$P_h_ = $con->real_escape_string($_GET['h']);
	$_SESSION['d_1'] = $e_;
	$_SESSION['d_2'] = $P_h_;
	$z = 0;
	$z_1 = 1;
		
	//RETRIEVING
	//CHECKING IF MAIL IS IN LIST
	//$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_' AND U_AP = '$z_1'";
	$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);		
	
	//MAIL ISN'T IN LIST
	if(mysqli_num_rows($query) == 0)
	{
		//SESSION VAR
		$_SESSION['message_1']="משהו לא עובד, אנא נסה שוב או צור איתנו קשר ב-registration@explainit.online<br><h4 id='c' style='margin:2px auto;'></h4>";
		$_SESSION['m_3'] = 1;
			
		//ERROR PAGE//OUTPUT 01
		header ("location: ../error_fi/error_videos.php");
	}//MAIL ISN'T IN LIST
	
	//MAIL IS IN LIST
	else
	{
		//USER REGISTERED MAIL BUT DIDN'T ACTIVATE ACCOUNT
		if($row["U_AP"] == 0)
		{
			//UPDATING AUTHORIZATION
			$sql = "UPDATE U_videos SET U_AP = '$z_1' WHERE U_M = '$e_'";
			$query = mysqli_query($con,$sql);
		}//ACCOUNT ACTIVATED
		
		//SESSION VAR
		$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>אנא בחר/י סיסמה חדשה</h1><div style='width:50%;margin:auto;'><hr></div>";	
	}//MAIL IS IN LIST
}//MAIL VARS ARE SET

//MAIL VARS AREN'T SET
else
{
	//SESSION VAR
	$_SESSION['message_1']="משהו לא עובד, אנא נסה שוב או צור איתנו קשר ב<br><h4 id='c' style='margin:2px auto;'>registration@explainit.online</h4>";
	
	//ERROR PAGE//OUTPUT 02
	header ("location: ../error_fi/error_videos.php");
}//MAIL VARS AREN'T SET

?>
<head>
	<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 03 -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 04 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 05 -->
	<link rel="stylesheet" href="../../css/2.css">
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
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
		background: #A9014B url(../../css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 06 */
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
	<!-- TEXT DIV -->
	<div style="text-align:center;width:100%;direction:rtl;">
		<?=$_SESSION['message_1'] ?>
		
		<!-- NEW PASSWORD FORM --><!-- OUTPUT 07 -->
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
		</form><!-- NEW PASSWORD FORM -->
	</div><!-- TEXT DIV -->
</body>