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

	//WE'RE CONNECTED, LOGOUT DATA
	date_default_timezone_set('Asia/Jerusalem');
	$logout_time = time();
	$date_logout = date('m/d/Y h:i:s a', $logout_time);
	
	//SESSION VARS
	$IP = $_SERVER['REMOTE_ADDR'];
	$U_name=$_SESSION['u_name'];	
	
	//UPDATING U_logged_in
	$sql = "UPDATE U_logged_in SET LOGGED_IN = 'N',LOGGED_OUT = 'Y',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time', LOGOUT_IP='$IP',CODE='N' WHERE U_N = '$U_name'";
	$query_2 = mysqli_query($con,$sql);
	
	//UPDATING U_LI WITH CURRENT LOG OUT 
	$sql = "UPDATE U_videos SET U_LI = '0' WHERE U_M = '$U_name'";
	$query_2 = mysqli_query($con,$sql);
	
	//UPDATING U_TP WITH CURRENT LOG OUT 
	$sql = "UPDATE U_videos SET U_TP = '0' WHERE U_M = '$U_name'";
	$query_2 = mysqli_query($con,$sql);
	
	//UPDATING U_logs
	$sql = "INSERT INTO U_logs (U_N,U_M,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE,LOGOUT_IP,PAGE) VALUES ('$U_name','$IP','SELF SIGNED OUT','0','$logout_time','$date_logout','$IP','L_00')";
	$query_3 = mysqli_query($con,$sql);
	
	//QUERIES SUCCESSFUL
	if($query_2&&$query_3)
	{
		//AFTER LOGOUT PAGE//OUTPUT
		header ("location: after_logout.php");
	}

?>						