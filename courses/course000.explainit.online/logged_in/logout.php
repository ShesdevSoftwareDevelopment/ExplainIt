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
	//DATABASE
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

	// LOGOUT DATA
	date_default_timezone_set('Asia/Jerusalem');
	$logout_time = time();
	$date_logout = date('m/d/Y h:i:s a', $logout_time);
	$IP = $_SERVER['REMOTE_ADDR'];
	$U_name=$_SESSION['u_name'];	
	
	// UPDATING U_logged_in
	$sql = "UPDATE U_logged_in SET LOGGED_IN = 'N',LOGGED_OUT = 'Y',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time', LOGOUT_IP='$IP',CODE='N' WHERE U_N = '$U_name'";
	$query_2 = mysqli_query($con,$sql);
	
	// UPDATING U_logs
	$sql = "UPDATE U_logs SET LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time', LOGOUT_IP='$IP' WHERE U_N = '$U_name'";
	$query_3 = mysqli_query($con,$sql);
	
	if($query_2&&$query_3)
	{
		//OUTPUT
		header ("location: after_logout.php");
	}

?>						