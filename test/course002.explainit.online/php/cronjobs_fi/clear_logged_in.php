<?php
	//ERRORS DISPLAY
	//error_reporting(E_ALL);
	//ini_set('display_errors', 'On');
	
	//DATABASE// Connecting//data
	
	//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
	/*	include "../test_fi/test_po_7_2.php";
		
		//GET DB DETAILS
		$new_path = 'test_01';
		$db_details = getfile($new_path,12);
		
		//CONNECTING//DATABASE//DATA
	
		$host = $db_details[0];
		$username = $db_details[1];
		$password = $db_details[2];
		$db = $db_details[3];
	*/
	
	//CONNECTING//DATABASE//DATA
	
		$host = 'localhost';
		$username = 'elad189g_xo_course002';
		$password = 'WhatsUpp_2019';
		$db = 'elad189g_xo_course002_us';
		
	// creating Connection
	$con = mysqli_connect($host, $username, $password,$db);
		
	// Selecting Database
	mysqli_select_db($con, $db); 
	
	// Enabling Hebrew
	mysqli_query($con,"SET character_set_client=utf8mb4");
	mysqli_query($con,"SET character_set_connection=utf8mb4");
	mysqli_query($con,"SET character_set_database=utf8mb4");
	mysqli_query($con,"SET character_set_results=utf8mb4");
	mysqli_query($con,"SET character_set_server=utf8mb4");
		
	//vars
	$d=time();
	
	//UPDATING LOG OUT
	$sql = "UPDATE `U_logged_in` SET `LOGGED_IN`= 'N' WHERE `LOGOUT_TIME` < '$d' ";
	$query = mysqli_query($con,$sql);
	
	//UPDATING U_TP WITH CURRENT LOG IN 
	$sql = "UPDATE `U_videos` SET `U_LI` = '0' WHERE `LOGOUT_TIME` < '$d' ";
	$query_2 = mysqli_query($con,$sql);
	
?>