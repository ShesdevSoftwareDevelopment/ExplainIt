<?php
//SESSION START
	session_start();

//ERRORS
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

//ENCODING
	header("Content-Type: text/html; charset=UTF-8");

//VARS
	$subject=$_POST["subject_1"];
	$question=$_POST["question_1"];
	$value=$_POST["value_1"];

//? ADD DIRECT ACCESS PROTECTION
	
//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
	include "../php/test_fi/test_po_6.php";
	
//GET DB DETAILS
	$new_path = $_SESSION['timestamp'];
	$db_details = getfile($new_path,12);

//CONNECTING//DATABASE//DATA
	$host = $db_details[0];
	$username = $db_details[1];
	$password = $db_details[2];
	$db = $db_details[3];
	
	//CONNECTION
	$con = mysqli_connect($host, $username, $password,$db);
	
	//CHECK
	if($con)
	{
		//echo '<i class="fa fa-check-square-o" style="font-size:24px;color:purple;"></i>';
		//echo 'connection ok';
	}
	else
	{
		die('Could not connect: ' . mysqli_error($con));
	}
		
	//SELECT DB
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
		
//SQL	
	//GETTING PREVIOUS VALUES
	$sql1="SELECT Q1,Q2,Q3,Q4,Q5,Q6,Q7,Q8,Q9,Q10,Q11,Q12,Q13,Q14,Q15,Q16 FROM colors ORDER BY TIME DESC LIMIT 1";
	$query = mysqli_query($con,$sql1);	
	$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
		
	//UPDATING NEW COLOR VALUE
	$row_1[$question] = $value;
	$row_2=implode(",",$row_1);
	
	//INSERTING NEW VALUES
	$sql1="INSERT INTO colors (Q1, Q2, Q3, Q4, Q5, Q6, Q7, Q8, Q9, Q10, Q11, Q12, Q13, Q14, Q15, Q16) VALUES (".$row_2.")";
	$query = mysqli_query($con,$sql1);	
	
	if($query)
	{
		echo 'OK';
	}
?>