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
	
	<!-- OUTPUT -->
	<!-- CSS -->
	<link rel="stylesheet" href="../../css/2.css">
	<!-- General stuff -->
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
		
// Vars
	$_SESSION['message_1']='';

// Data

if (isset($_GET['e']) && !empty($_GET['e']) AND isset($_GET['h']) && !empty($_GET['h']))
{
	//DATABASE
	// CONNECTING
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
	
	// Sanitizing
	$e_ = $con->real_escape_string($_GET['e']);
	$P_h_ = $con->real_escape_string($_GET['h']);
	$z = 0;
	$z_1 = 1;
		
	//retrieving
	$sql = "SELECT * FROM U_videos WHERE U_M = '$e_' AND U_IO = '$P_h_' AND U_AP = '$z'";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);	
	
	$_SESSION['u_n'] = $row['U_N'];
	
	if(mysqli_num_rows($query) == 0)
	{
		$_SESSION['message_1']="החשבון הופעל כבר<br><div style='width:50%;margin:auto;'><hr></div><h4 id='d' style='margin:2px auto;'>את/ה מועבר/ת לדף התחברות</h4>";
		echo '<script>setTimeout(function(){$("#d").click();}, 4000);</script>';
		//header ("location: ../s8_f/s8.php");
	}
	else
	{
		//updating
		$sql = "UPDATE U_videos SET U_AP = '$z_1' WHERE U_M = '$e_'";
		$query = mysqli_query($con,$sql);
		$_SESSION['active'] = 1;
		$_SESSION['wl'] = 1;
		
		//echo '<script>setTimeout(function(){$("#c").click();}, 1000);</script>';
		
		//OUTPUT
		header ("location: ../wl_fi/wl_videos.php");
	}
}
else
{
	if(isset($_SESSION['v_wait']))
	{
		if ($_SESSION['v_wait'] == 1)
		{
			$_SESSION['message_1']="לחץ על הקישור שנשלח במייל<br><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>כדי להפעיל את החשבון</h4>";	
		}
		else
		{
			if($_SESSION['m']== 1)
			{
				$_SESSION['message_1']="לחץ על הלינק שנשלח במייל<br><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>כדי להשלים את החלפת הסיסמה</h4>";
			}
			else
			{
				//OUTPUT
				header ("location: ../error_fi/error_videos.php");
			}
		}
	}
	else
	{
		//OUTPUT
		header ("location: ../../index.php");
	}
}

?>

<body>
<div style="text-align:center;width:100%;">
	<h1 style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
</div>
<script>

//OUTPUT
$("#c").click(function(){
	window.location.replace("../../php/wl_fi/wl_videos.php");
	});
	
//OUTPUT
$("#d").click(function(){
	window.location.replace("../../login/example_cleveland_l_videos.php");
	});
</script>
</body>