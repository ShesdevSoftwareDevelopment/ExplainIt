<?php
//SESSION START
	session_start();

//ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

//HTTPS REDIRECT
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}

//SESSION VARS	
	$_SESSION["refresh_count"]=3;
	$course_number = '006';
	
	
//FUNCTIONS
//FUNCTION TO GET HASHED USER CODE FROM TIMESTAMP AFTER 0 CHANGED
// - GETS TIMESTAMP AFTER 0 CHANGED.
// - CREATES COMPLETING NUMBERS.
// - HASHES ALL NUMBERS AND PUTS IN ARRAY.
//RETURNS THE ORIGINAL USER CODE ARRAY AFTER HASHING 
	function set_num($m)//$m IS TIMESTAMP AFTER 0 CHANGED
	{

		//DEBUGGING	
		//echo '<pre style="direction:ltr;">';
		//echo 'm:<br>';
		//var_dump($m);
				
		//GETTING $m ALL CHARS EXCEPT LAST (EXAMPLE:$m = "BANANA" --> $b = "BANAN")
		$b = substr($m, 0, -1);
		
		//GETTING LAST CHAR IN $m AND TURNING IT TO INT (EXAMPLE:$m = "BANANA9" --> $a[0] = "9")
		$a[0]= intval(substr($m, -1));

		//DEBUGGING
		//echo 'a:<br>';
		//var_dump($a);
		
		//CREATING ARRAY OF COMPLETING 0-9 LAST CHARS
		for($i=1;$i<10;$i++)
		{
			if($a[$i-1] == 9)
			{
				$a[$i] = 0;
				continue;		
			}
			else
			{
				$a[$i]=$a[$i-1]+1;
			}
		}
		
		//NOW WE'VE GOT 0-9 IN a ARRAY
		
		//DEBUGGING		
		//echo 'a after loop:<br>';
		//var_dump($a);
		
		//CREATING COMPLETING $m NUMBERS
		for($i=0;$i<10;$i++)
		{
			$b_array[$i] = $b.$a[$i];
		}
		
		//NOW WE'VE GOT COMPLETING $m NUMBERS IN $b_array
		
		//DEBUGGING		
		//echo 'b after loop:<br>';
		//var_dump($b_array);
		
		// SORTING
		$c[0]=$b_array[4];
		$c[1]=$b_array[5];
		$c[2]=$b_array[6];
		$c[3]=$b_array[7];
		$c[4]=$b_array[8];
		$c[5]=$b_array[9];
		$c[6]=$b_array[0];//THE ORIGINAL ONE
		$c[7]=$b_array[1];
		$c[8]=$b_array[2];
		$c[9]=$b_array[3];
		
		//NOW WE'VE GOT SEQUENCING $m NUMBERS IN $c ARRAY
		
		//HASHING
		
		for($i=0;$i<count($c);$i++)//md5
		{
			$d[$i] = md5($c[$i]);
		}
		
		//NOW WE'VE GOT HASHED SEQUENCING $m NUMBERS IN $d ARRAY
		
		//DEBUGGING
		/*	echo '<pre style="direction:ltr;">';
			echo 'count_c:<br>';
			echo count($c);
			echo 'd:<br>';
			var_dump($d);
		*/
		
		//CHANGING A'S//MORE HASHING
		//EVERY $m (WORD)
		for($i=0;$i<count($d);$i++)
		{
			//EVERY CHAR ON ITS OWN
			for($j=0;$j<strlen($d[$i]);$j++)
			{
				//THE CURRENTLY CHECKED CHAR
				$f=substr($d[$i], $j, 1);
				
				//FIRST CHAR
				if($j == 0)
				{
					$e[$i]=$f;
					continue;
				}	
				
				//CHANGE A'S
				if($f=='a')
				{
					$e[$i]=$e[$i].'p';
				}
				else//CONTINUE BUILDING THE NEW STRING IN e ARRAY
				{
					$e[$i]=$e[$i].$f;
				}
			}
		}
		
		//NOW WE'VE GOT HASHED AND AFTER A'S REPLACEMENT SEQUENCING $m NUMBERS IN $e ARRAY
		
		//DEBUGGING
		/*	echo '<br>';
			var_dump($e);
			echo '</pre>';		
		*/		
		
		//SESSION VARS
		$_SESSION['y_not']=$e[6];//THE CORRECT ONE
		$_SESSION['y_not_IP']=$_SERVER['REMOTE_ADDR'];//IP
		
		//RETURNING THE ORIGINAL USER CODE ARRAY AFTER HASHING
		return $e;
	}	
	
	function check_status($course_number)
	{
		// CONNECTING
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
			
		//SELECTING DATABASE
		mysqli_select_db($con, $db_details[3]); 
		
		// Enabling Hebrew
		mysqli_query($con,"SET character_set_client=utf8mb4");
		mysqli_query($con,"SET character_set_connection=utf8mb4");
		mysqli_query($con,"SET character_set_database=utf8mb4");
		mysqli_query($con,"SET character_set_results=utf8mb4");
		mysqli_query($con,"SET character_set_server=utf8mb4");
		
		// Setting Time	
		$sql_Time = "SET time_zone = '+03:00';";
		$query = mysqli_query($con,$sql_Time);
	
	//CONNECTED.
	
	//CHECK FOR PAID STATUS
		$status_01 = $_SESSION['timestamp'];
		$sql = "SELECT U_M,PAID FROM U_videos WHERE U_T1 ='$status_01'";
		$query = mysqli_query($con,$sql);
		
		// NEW DATA ARRAY
		$drillArray = array(); 
		$index = 0;
		
		// loop to store the data in an associative array.
		while($row = mysqli_fetch_assoc($query))
		{ 
			$drillArray[$index] = $row;
			$index++;
		}
		
		$U_name = $drillArray[0]['U_M'];
		$result_01 = $drillArray[0]['PAID'];
		
		if($result_01 == 'Y')
		{
			return(1);
		}
		
		else
		{
			if(isset($_SESSION['timestamp']))
			{
				//ATTRIBUTES//OUTPUT 11
				$f = "registration@explainit.online";
				$f_1="Explainit Online - קורס ".$course_number." - משתמש נותק";
						
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;">';
				$message .= '<h4>RECORDS SHOW HE/SHE DID NOT PAY</h4>';
				$message .= '<h4>מייל:</h4>';
				$message .= '<h4>'.$U_name.'</h4>';
				$message .= '<h4>IP:</h4>';
				$message .= '<h4>'.$_SERVER["REMOTE_ADDR"].'</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($f,$f_1,$message,$headers);
			}
			
			return(0);
		}
	
	}
	//USER LOGGED IN SUCCESSFULLY
	//if($_SESSION['loggedin'] == 1)
	if(check_status($course_number))
	{
		//SESSION VARS
		$_SESSION['count'] = 0;
		$_SESSION['wl'] = 0;
		$_SESSION['v_wait'] = 0;
		$course_number = '006';
		
		//GETTING HASHED USER CODE
		$v=set_num($_SESSION['timestamp']);//check no.6
	?>

<!DOCTYPE html>
<html lang="iw" dir="rtl">
<head>
	<!-- GOOGLE ANALYTICS --><!-- OUTPUT 00 -->
		
	<!-- ENCODING -->
	<meta charset="utf-8">
		
	<!-- FAVICON --><!-- OUTPUT 01 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 02 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- EMOJI CSS --><!-- OUTPUT 03 -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
			
	<!-- STYLING -->
	<style>
	
	/* METAL TABLES*/

	/* B0 */
	
	#table_b0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b0 td, #table_b0 th
	{
		border-collapse: collapse;
	}
	
	/* B01 */
	
	#table_b01
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b01 td, #table_b01 th
	{
		border-collapse: collapse;
	}
	
	/* B1 */
	
	#table_b1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b1 td, #table_b1 th
	{
		border-collapse: collapse;
	}
	
	/* B2 */
	
	#table_b2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b2 td, #table_b2 th
	{
		border-collapse: collapse;
	}
	
	.tr_border
	{
		border: 1px solid black;
	}
	
	/* B3 */
	
	#table_b3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b3 td, #table_b3 th
	{
		border-collapse: collapse;
	}

	/* B4 */
	
	#table_b4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b4 td, #table_b4 th
	{
		border-collapse: collapse;
	}
	
	/* B5 */
	
	#table_b5
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b5 td, #table_b5 th
	{
		border-collapse: collapse;
	}

	/* B6 */
	
	#table_b6
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b6 td, #table_b6 th
	{
		border-collapse: collapse;
	}
	
	/* B7 */
	
	#table_b7
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b7 td, #table_b7 th
	{
		border-collapse: collapse;
	}
	
	/* b8 */
	
	#table_b8
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b8 td, #table_b8 th
	{
		border-collapse: collapse;
	}
	
	/* B9 */
	
	#table_b9
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b9 td, #table_b9 th
	{
		border-collapse: collapse;
	}
	
	/* B10 */
	
	#table_b10
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b10 td, #table_b10 th
	{
		border-collapse: collapse;
	}
	
	/* B11 */
	
	#table_b11
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b11 td, #table_b11 th
	{
		border-collapse: collapse;
	}

	/* B12 */
	
	#table_b12
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b12 td, #table_b12 th
	{
		border-collapse: collapse;
	}
	
	/* B13 */
	
	#table_b13
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b13 td, #table_b13 th
	{
		border-collapse: collapse;
	}
	
	/* B14 */
	
	#table_b14
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b14 td, #table_b14 th
	{
		border-collapse: collapse;
	}
	
	/* B15 */
	
	#table_b15
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b15 td, #table_b15 th
	{
		border-collapse: collapse;
	}
	
	/* B16 */
	
	#table_b16
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b16 td, #table_b16 th
	{
		border-collapse: collapse;
	}
		
	/* BUTTON *//*http://jeromejaglale.com/doc/css/pretty_button*/	
	.button 
	{
		/*font: bold 13px "Helvetica Neue", Helvetica, Arial, clean, sans-serif !important;*/
		/*text-shadow: 0 -1px 1px rgba(0,0,0,0.25), -2px 0 1px rgba(0,0,0,0.25);*/
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		/*-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.5);*/
		/*-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.5);*/
		display: inline-block;
		color: white;
		padding: 5px 10px 5px;
		/*white-space: nowrap;*//*CHANGED*/
		white-space: normal;
		text-decoration: none;
		cursor: pointer;
		background: #a9014b url(../css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */
		border-style: none;
		text-align: center;
		overflow: visible;
	}
	
	.button:hover
	/*,.button:focus*//*REMOVED*/
	{
		background-color: #1ebbd7;/*ADDED*/
		background:#1ebbd7 url(../css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */;
		outline:0;/*ADDED*/
		/*background-position: 0 -50px;*/
		/*color: white;*/
	}
	
	.button:active 
	{
		background-position: 0 -100px;
		/*-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.7);*/
		-webkit-box-shadow: none;
	}
	
		/* General stuff 2.css */
		
		section, footer, nav {
		display: block;
		}
		
		body 
		{
			/*font-family: 'Varela Round', sans-serif;*/
			-webkit-text-size-adjust: none;
			color: #333;
			max-width: 720px;
			margin: 0 auto;
			padding: 10px;
			/* Background pattern from Toptal Subtle Patterns */
			/* background-image:url(../img/background/grey_wash_wall.png);*/
		}
		
		html {
			background-color:#2a6456;
		}
	/* WHEN COMMENTING OUT BODY LOADER LOADS IN MIDDLE OF SCREEN */	
	
	/*	input
		{
		font-family: 'Varela Round', sans-serif;
		}
	*/	
		a {
		color: blue;
		color: hsl( 220, 90%, 40% );
		text-decoration: none;
		}
		
		a:hover {
		/*background-color: blue;*/
		/*background-color: hsl( 220, 90%, 50% );*/
		color: white;
		}
	
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
			/*white-space: nowrap;*/
			text-decoration: none;
			cursor: pointer;
			/*background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;*//* OUTPUT 04 */
			border-style: none;
			text-align: center;
			overflow: visible;
		}
	
		#options {
		position: relative;
		z-index: 100;
		margin-bottom: 40px;
		}
		
		footer {
		/*border-top: 1px solid #CCC;*/
		font-size: 0.8em;
		position: relative;
		z-index: 100;
		}
		
		#disclaimer {
		color: red;
		font-weight: bold;
		display: none;
		}
		.no-csstransforms3d #disclaimer { display: block; }
		
		hr {
		border: none;
		border-top: 1px solid #CCC;
		}
		
		figure {
		margin: 0;
		}
		
		code {
		font-family: 'Monaco', 'Menlo', monospace;
		}
		
		/*---------------*/
			* 
			{
				/*font-family: 'Varela Round', sans-serif;*/
				font-family: 'Secular One', sans-serif;
				box-sizing:border-box;
			}
					
			#div_upper 
			{
				width:100%;
				background-color:green;
				color:white;
			}
				
			#div_event 
			{	
				width:100%;
				background-color:purple;
			}
			
			#div_trail
			{
				float:right;
				/*height:20%;*/
				/*overflow-x:scroll;*/
			}
			
			#station_table
			{
				border-collapse:collapse;
			}
							
			#station_table td
			{
				border:0.5px solid black;
				border-collapse:collapse;
			}
			
			#station_result,
			#station_result_1_1
			{
				margin-right:6px;
				margin-top:9px;
			}
			
			#station_result>b 
			{
				font-size:16px;
			}
			
			#station_header,
			#station_header_2
			{
				width:100%;
			}
				
			#station_header>b 
			{
				font-size:16px;
			}
			
			#station_header_2>b 
			{
				font-size:16px;
			}
			
			#station_result_1_1>b 
			{
				font-size:16px;
			}
			
			#station_result,
			#station_result_1_1,
			#station_result_home
			
			{
				/*
				display:inline-block;
				margin-top:3px;
				margin-bottom:3px;
				*/
				float:right;
				height:100%;
			}
			
			#station_result_home,
			#station_result_home_2,
			#station_result_home_3,
			
			#div_story
			{
				display:inline-block;
				text-align:center;
				font-size:16px;
				border:1px black solid;
				padding:2px 4px;
				vertical-align:top;
				margin-top:3px;
				margin-bottom:3px;
			}
			
			#station_result_home
			{
				margin:6px auto;
			}
			
			#div_story
			{
				display:block;
				text-align:initial;
			}
			
			#station_result,
			#station_result_1_1
			{
				border-radius:13px 0px 13px 13px;
				border:dashed;
				padding:14px 6px;
			}
			
			#station_result_home
			{
				border-radius:14px;
				border:solid;
				margin-right:6px;
				padding:14px 6px;
			}
			
			a,li
			{
		
				/* These are technically the same, but use both */
				overflow-wrap: break-word;
				word-wrap: break-word;
		
				-ms-word-break: break-all;
				/* This is the dangerous one in WebKit, as it breaks things wherever */
				word-break: break-all;
				/* Instead use this non-standard one: */
				word-break: break-word;
		
				/* Adds a hyphen where the word breaks, if supported (No Blink) */
				-ms-hyphens: auto;
				-moz-hyphens: auto;
				-webkit-hyphens: auto;
				hyphens: auto;
		
				}
				
				
				* {font-size:16px;}
				
				div[contenteditable]
				{
					border: 1px solid black;
					max-height: 200px;
					overflow: auto;
				}
				
					@media only screen and (max-width: 500px)
					{
						
						.responsive 
						{
						width: 100%;
						}
						
						.dropdown-content_co 
						{
						top: -4px;
						}
						
						/*checking something*/
						#station_result,
						#station_result_1_1,
						#station_result_home,
						#station_result_home_2,
						#station_result_home_3,
						#station_header,
						#station_header_2
						{
							width:100%;
							margin-top:3px;
							margin-bottom:3px;
							text-align:center;
						}
						
						#div_trail
						{
							height:initial;
							overflow-y:scroll;
							overflow-x:hidden;
						}
					}
					
					.clearfix:after 
					{
						content: "";
						display: table;
						clear: both;
					}
					
								
				/*Tables and other stuff from 2.php*/	
						
					#div_header_2 
					{
						width:100%;
						background-color:blue;
					}
					
					#div_table_names 
					{
						width:100%;
						margin:auto;
					}
					
					#div_table_drills 
					{
						width:100%;
						margin:auto;
					}
						
					#table_names 
					{	
						width:100%;
						margin:auto;
						border:1px solid black;
						text-align:center;
						border-collapse:collapse;
					}
					
					#table_names th 
					{
						border:1px solid black;
						border-collapse:collapse;
					}
						
					.table_drills 
					{
						width:100%;
						margin:auto;
						/*border:1px solid black;*/
						text-align:center;
						border-collapse:collapse;
					}
					
					.table_drills th 
					{
						border:1px solid black;
						border-collapse:collapse;
					}
					
					.table_drills td 
					{
						border:1px black solid;
						/*border-right-style:ridge;*/
					}
					
					//SUBSUBJECT TABLE
					.subsubject_table 
					{
						width:100%;
						margin:auto;
						/*border:1px solid black;*/
						text-align:center;
						border-collapse:collapse;
					}
					
					.subsubject_table th 
					{
						border:1px solid black;
						border-top:none;
						border-bottom:none;
						border-collapse:collapse;
					}
					
					.subsubject_table td 
					{
						text-align:center;
						border-top:none; 
						
					}
					
					#table_colors td 
					{
						border:none;
					}
					
					hr 
					{
						margin:0.5px;
					}
					
					#hr_1 
					{
						margin:-0.5px;
						height:0.75px;
						background-color:darkgrey;
					}
						
					#hr_2 
					{
						margin:0.5px;
						border-style:solid;
					}
				
					.giraffe,
					.example,
					.car,
					.steel,
					.paper,
					.rock,
					.tree, 
					.water,
					.metal,
					.oil,
					.copper,
					.bronze,
					.silver,
					.gold,
					{
						display:none;
					}
					
					#comments_list a {
						/*display:inline;*/
						margin:0px;
					}
								
					/* w3schools loader */
					
					#div_header_3,
					#div_table_drills,
					#hr_number_1,
					#footer_1,
					#a1_index,
					#a1_index_h3,
					.a1_b1_index,
					#middle_content
					{
						opacity:0;
					}
					
					.loader {
					//position:absolute;
					//left:40%;
					//top:40vh;
					margin:auto;
					margin-top:100px;
					border: 16px solid #f3f3f3;
					border-radius: 50%;
					border-top: 16px solid #3498db;
					width: 120px;
					height: 120px;
					-webkit-animation: spin 2s linear infinite;
					animation: spin 2s linear infinite;
					}
		
					@-webkit-keyframes spin {
					0% { -webkit-transform: rotate(0deg); }
					100% { -webkit-transform: rotate(360deg); }
					}
		
					@keyframes spin {
					0% { transform: rotate(0deg); }
					100% { transform: rotate(360deg); }
					}
					
		
		body {
		-webkit-text-size-adjust: none;
		color: #333;
		margin: 0 auto;
		padding: 10px;
		}
		
		* {
			box-sizing: border-box;
		}
		
		input 
		{
			border-radius:0px;
		}
		
		#status_div_1
		{
			background-color:green;
		}
		
		#subject_a1_b1,#subject_a1_b2
		{
			cursor:pointer;
		}
	
	/* GENERAL */
				
	.station_1
	{
		display:none;
	}
		
	.station
	{
		margin: auto;
		text-align: center;
		opacity: 1;
		float: right;
		border: 1px black solid;
		border-radius: 5px;
		padding: 0px 5px;
		margin-top: 5px;
	}
	
	/*no_top_border*/
	#a1_b2,
	#a1_b2_main
	{
		border-top:0px;
	}
	
	.can_be_clicked
	{
		background-color:#A9014B;
	}
	
	.hidden
	{
		display:none;
	}
	
	.clicked
	{
		background-color:#1ebbd7;
	}
	
	.unclicked
	{
		background:#a9014b url(../css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */;
	}
	
	.td_click
	{
		display:none;
	}
	
	.subject_td:hover,
	.subject_td:focus 
	{
		background-color: #1ebbd7;/*ADDED*/
		outline:0;/*ADDED*/
	}
	
	.subject_td:active 
	{
		background-position: 0 -100px;
		-webkit-box-shadow: none;
	}
	
	@media only screen and (max-width: 500px)
	{
		#table_colors td 
		{
			padding:0px 2px;
		}
		
		.in_table_td 
		{
			padding:0px 2px;
		}
	}	
	
	/* CLASSES */
	
	.got_it
	{
		background: green url(../css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */
	}
	
	.didnt_get_it
	{
		background: red url(../css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */
	}
	
/* TEMPLATE */

	body
		{
			/* Background pattern from Toptal Subtle Patterns */
			/*background-image:url(../../../../img/background/tic-tac-toe_09.jpg);*/
			/*background-image:url(../img/background/grey_wash_wall.png);*/
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
		
	.clicked
	{
		background:#1ebbd7 url(../css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */;
	}
	
	</style>
</head>

<body style="width:100%;position:relative;">

	<!-- LOADER -->
	<div class="loader"></div>
	
	<script>
		//LOGGING 
		//console.log("---loader")
			
		//SETTING WIDTH VARIABLE
		var a_11_loader = $(document.body).outerWidth()/2-60;
			
		//DEBUGGING
		//console.log("window width: ",$(window).outerWidth());
		//console.log("width from left: ",a_11);
			
		//setting height variable
			var a_12_loader = $(window).outerHeight()/2-60;
			
		//console.log("window height: ",$(window).outerHeight());
		//console.log("height from top: ",a_12_loader);
		
		//setting height and width
		//*$('.loader').css("left",a_11_loader);
		$('.loader').css("left","35%");
		$('.loader').css("top",a_12_loader);
	</script>		

	<!-- Commercials -->	
		<!--
			<div class="commercial" style="position:absolute;right:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:220px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:430px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:640px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:850px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			
			<div class="commercial" style="position:absolute;left:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"><img src="pics/saved.png" style="width:100%;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:220px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:430px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:640px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:850px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		-->
			
	<!-- Middle Content -->	
	<div id="middle_content" style="float:right;right:0px;float:right;width:100%;;max-width:720px;">
						
		<!-- TOP BUTTONS MENU -->
		<div style="float:right;">
			<!-- LOGOUT PAGE --><!-- OUTPUT 04 -->
			<a href="logout.php"><div id="logout_div" style="margin:2px 2px 1px 0px;padding:0px 6px;border:1px black solid;float:right;">התנתק/י</div></a>
		</div>
		
		<div style="float:right;">
			<div id="status_div_1" style="margin:2px 2px 1px 0px;padding:0px 6px;border:1px black solid;float:right;color:white;">מחובר/ת</div>
		</div>
				
		<div id="div_header_3" style="float:right;text-align:center;font-size:24px;position:relative;top:0px;width:100%;">
			<!-- HEADER -->
			<h1 id="page_h1" style="margin-bottom:0px 0px 0px 0px;font-size:24px;">סרטונים לפי נושא</h1>						
			
			<!-- HR -->
			<div style="width:50%;margin:auto;">
				<hr>
			</div>
		</div>	
			<!-- SELECT SUBJECT 00 -->
			<!-- PART 1 -->
				<table id="table_b0" style="margin-top:2.5px;">
						<tr>
							<!-- PART 1 PIC -->
							<th id="b0_1" colspan="4" style="border-right-style:none;"><!-- PART 01 PIC --><!-- OUTPUT 05 --><img class="output" src="../img/table/01.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;"></td>
						</tr>
				</table>
				
			<!-- SUBJECT 01 -->
				<table id="table_b1" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 01 ICON --><!-- OUTPUT 06 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 01 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b1_1" class="responsive_input_4 button a1_b1_c1_main" style="width:100%;">קינמטיקה | מבוא&nbsp; <span id="a1_b1_c1_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b1">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b1">
							<td id="td_pic_01" colspan="5" style="text-align:center;padding:2px 10px;border-right-style:none;position:relative;"><!-- SUBJECT 01 THUMBNAIL --><!-- OUTPUT 07 --><img class="output" src="../img/login/thumbnails/01.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c1 TABLE -->
				
				<table id="a1_b1_c1_table" class="subsubject_table b1" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b1">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										<!-- 2 BUTTONS -->
										<td style="text-align:center;position:relative;">
										
											<!-- BUTTON -->
											<button id="play_icon_a1_b1_c1" class="responsive_input_4 button" style="width:100%;margin:auto;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
																
										</td>
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b1">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b1">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b1">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b1">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c1" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b1">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c1" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c1" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b1">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b1">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b1">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c1" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c1" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b1">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c1 -->		
				
			<!-- SUBJECT 02 -->
				<table id="table_b2" style="margin-top:2.5px;">
					<tr>
						<!-- ICON -->
						<th style="width:30px;border-style:none;"><!-- SUBJECT 02 ICON --><!-- OUTPUT 08 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
						
						<!-- SUBJECT 02 -->
						<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
							<div style="width:100%;margin:auto;">
								<button id="b2_1" class="responsive_input_4 button a1_b1_c2_main" style="width:100%;">קינמטיקה | גרפים&nbsp; <span id="a1_b1_c2_views"></span></button>
							</div>
						</th>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b2">
						<td colspan="5" style="border-right-style:none;"><hr></td>
					</tr>
					
					<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
					<tr class="b2">
						<td id="td_pic_02" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 02 THUMBNAIL --><!-- OUTPUT 09 --><img class="output" src="../img/login/thumbnails/02.jpg" style="width:100%;"></td>
					</tr>
				</table>
				
				<!-- a1_b1_c2 TABLE -->
				
				<table id="a1_b1_c2_table" class="subsubject_table b2" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b2">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c2" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b2">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b2">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b2">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b2">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c2" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b2">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c2" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c2" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b2">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b2">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b2">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c2" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c2" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b2">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c2 -->		
			
			<!-- SUBJECT 03 -->
				<table id="table_b3" style="margin-top:2.5px;">
					<tr>
						<!-- ICON -->
						<th style="width:30px;border-style:none;"><!-- SUBJECT 03 ICON --><!-- OUTPUT 10 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
						
						<!-- SUBJECT 03 -->
						<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
							<div style="width:100%;margin:auto;">
								<button id="b3_1" class="responsive_input_4 button a1_b1_c3_main" style="width:100%;">כוחות&nbsp; <span id="a1_b1_c3_views"></span></button>
							</div>
						</th>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b3">
						<td colspan="5" style="border-right-style:none;"><hr></td>
					</tr>
					
					<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
					<tr class="b3">
						<td id="td_pic_03" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 03 THUMBNAIL --><!-- OUTPUT 11 --><img class="output" src="../img/login/thumbnails/03.jpg" style="width:100%;"></td>
					</tr>
				</table>
				
				<!-- a1_b1_c3 TABLE -->
				
				<table id="a1_b1_c3_table" class="subsubject_table b3" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b3">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c3" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b3">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b3">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b3">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b3">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c3" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b3">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c3" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c3" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b3">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b3">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b3">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c3" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c3" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b3">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c3 -->
								
			<!-- SUBJECT 04 -->
				<table id="table_b4" style="margin-top:2.5px;">
					<tr>
						<!-- ICON -->
						<th style="width:30px;border-style:none;"><!-- SUBJECT 04 ICON --><!-- OUTPUT 12 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
						
						<!-- SUBJECT 04 -->
						<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
							<div style="width:100%;margin:auto;">
								<button id="b4_1" class="responsive_input_4 button a1_b1_c4_main" style="width:100%;">כוחות | המשך&nbsp; <span id="a1_b1_c4_views"></span></button>
							</div>
						</th>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b4">
						<td colspan="5" style="border-right-style:none;"><hr></td>
					</tr>
					
					<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
					<tr class="b4">
						<td id="td_pic_04" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 04 THUMBNAIL --><!-- OUTPUT 13 --><img class="output" src="../img/login/thumbnails/04.jpg" style="width:100%;"></td>
					</tr>
				</table>
			
			<!-- a1_b1_c4 TABLE -->
				
				<table id="a1_b1_c4_table" class="subsubject_table b4" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b4">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c4" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b4">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b4">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b4">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b4">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c4" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b4">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c4" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c4" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b4">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b4">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b4">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c4" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c4" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b4">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c4 -->		
						
			<!-- SUBJECT 05 -->
				<table id="table_b5" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 05 ICON --><!-- OUTPUT 15 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 05 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b5_1" class="responsive_input_4 button a1_b1_c5_main" style="width:100%;">קינמטיקה | המשך&nbsp; <span id="a1_b1_c5_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b5">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b5">
							<td id="td_pic_05" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 05 THUMBNAIL --><!-- OUTPUT 16 --><img class="output" src="../img/login/thumbnails/05.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c5 TABLE -->
				
				<table id="a1_b1_c1_table" class="subsubject_table b5" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b5">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c5" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b5">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b5">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b5">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b5">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c5" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b5">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c5" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c5" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b5">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b5">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b5">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c5" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c5" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b5">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c5 -->		
								
			
			<!-- PART 2 -->
				<table id="table_b01" style="margin-top:2.5px;">
						<tr>
							<!-- PART 2 PIC -->
							<th id="b01_1" colspan="4" style="border-right-style:none;"><!-- PART 2 PIC --><!-- OUTPUT 14 --><img class="output" src="../img/table/02.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;"></td>
						</tr>
				</table>	
						
			<!-- SUBJECT 06 -->
				<table id="table_b6" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 06 ICON --><!-- OUTPUT 17 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 06 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b6_1" class="responsive_input_4 button a1_b1_c6_main" style="width:100%;">אנרגיה ועבודה&nbsp; <span id="a1_b1_c6_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b6">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b6">
							<td id="td_pic_06" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 06 THUMBNAIL --><!-- OUTPUT 18 --><img class="output" src="../img/login/thumbnails/06.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c6 TABLE -->
				
				<table id="a1_b1_c6_table" class="subsubject_table b6" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b6">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c6" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b6">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b6">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b6">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b6">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c6" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b6">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c6" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c6" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b6">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b6">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b6">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c6" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c6" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b6">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c6 -->		
			
						
			<!-- SUBJECT 07 -->
				<table id="table_b7" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 07 ICON --><!-- OUTPUT 19 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 07 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b7_1" class="responsive_input_4 button a1_b1_c7_main" style="width:100%;">תנע ומתקף | חד מימד&nbsp; <span id="a1_b1_c7_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b7">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b7">
							<td id="td_pic_07" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 07 THUMBNAIL --><!-- OUTPUT 20 --><img class="output" src="../img/login/thumbnails/07.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c7 TABLE -->
				
				<table id="a1_b1_c7_table" class="subsubject_table b7" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b7">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c7" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b7">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b7">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b7">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b7">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c7" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b7">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c7" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c7" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b7">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b7">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b7">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c7" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c7" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b7">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c7 -->		
				
			<!-- SUBJECT 08 -->
				<table id="table_b8" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT ICON --><!-- OUTPUT 21 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 08 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b8_1" class="responsive_input_4 button a1_b1_c8_main" style="width:100%;">תנע ומתקף | דו מימד&nbsp; <span id="a1_b1_c8_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b8">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b8">
							<td id="td_pic_08" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 08 THUMBNAIL --><!-- OUTPUT 22 --><img class="output" src="../img/login/thumbnails/08.jpg" style="width:100%;"></td>
						</tr>
				</table>
			
				<!-- a1_b1_c8 TABLE -->
				
				<table id="a1_b1_c8_table" class="subsubject_table b8" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b8">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c8" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b8">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b8">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b8">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b8">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c8" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b8">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c8" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c8" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b8">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b8">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b8">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c8" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c8" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b8">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c8 -->		
			
			<!-- PART 3 -->
				<table id="table_b02" style="margin-top:2.5px;">
						<tr>
							<!-- PART 3 PIC -->
							<th id="b02_1" colspan="4" style="border-right-style:none;"><!-- PART 3 PIC --><!-- OUTPUT 23 --><img class="output" src="../img/table/03.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;"></td>
						</tr>
				</table>	
						
			<!-- SUBJECT 09 -->
				<table id="table_b9" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 09 ICON --><!-- OUTPUT 24 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 09 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b9_1" class="responsive_input_4 button a1_b1_c9_main" style="width:100%;">תנועה מעגלית אפקית&nbsp; <span id="a1_b1_c9_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b9">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b9">
							<td id="td_pic_09" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 09 THUMBNAIL --><!-- OUTPUT 25 --><img class="output" src="../img/login/thumbnails/09.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c9 TABLE -->
				
				<table id="a1_b1_c9_table" class="subsubject_table b9" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b9">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c9" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b9">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b9">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b9">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b9">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c9" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b9">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c9" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c9" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b9">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b9">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b9">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c9" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c9" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b9">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c9 -->		
					
				
			<!-- SUBJECT 10 -->
				<table id="table_b10" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 10 ICON --><!-- OUTPUT 26 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 10 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b10_1" class="responsive_input_4 button a1_b1_c10_main" style="width:100%;">תנועה מעגלית אנכית&nbsp; <span id="a1_b1_c10_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b10">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b10">
							<td id="td_pic_10" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 10 THUMBNAIL --><!-- OUTPUT 27 --><img class="output" src="../img/login/thumbnails/10.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c10 TABLE -->
				
				<table id="a1_b1_c10_table" class="subsubject_table b10" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b10">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c10" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b10">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b10">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b10">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b10">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c10" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b10">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c10" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c10" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b10">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b10">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b10">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c10" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c10" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b10">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c10 -->		
				
			<!-- SUBJECT 11 -->
				<table id="table_b11" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 11 ICON --><!-- OUTPUT 28 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 11 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b11_1" class="responsive_input_4 button a1_b1_c11_main" style="width:100%;">כבידה&nbsp; <span id="a1_b1_c11_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b11">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b11">
							<td id="td_pic_11" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 11 THUMBNAIL --><!-- OUTPUT 29 --><img class="output" src="../img/login/thumbnails/11.jpg" style="width:100%;"></td>
						</tr>
				</table>
				
				<!-- a1_b1_c11 TABLE -->
				
				<table id="a1_b1_c11_table" class="subsubject_table b11" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b11">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c11" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b11">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b11">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b11">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b11">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c11" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b11">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c11" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c11" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b11">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b11">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b11">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c11" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c11" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b11">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c11 -->		
			
			<!-- SUBJECT 12 -->
				<table id="table_b12" style="margin-top:2.5px;">
						<tr>
							<!-- ICON -->
							<th style="width:30px;border-style:none;"><!-- SUBJECT 12 ICON --><!-- OUTPUT 30 --><img class="output" src="../img/icons/BOOKS_5.png" style="width:95%;"></td>
							
							<!-- SUBJECT 12 -->
							<th colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
								<div style="width:100%;margin:auto;">
									<button id="b12_1" class="responsive_input_4 button a1_b1_c12_main" style="width:100%;">תנועה הרמונית&nbsp; <span id="a1_b1_c12_views"></span></button>
								</div>
							</th>
						</tr>
						
						<!-- HORIZONTAL LINE -->
						<tr class="b12">
							<td colspan="5" style="border-right-style:none;"><hr></td>
						</tr>
						
						<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO -->
						<tr class="b12">
							<td id="td_pic_12" colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;"><!-- SUBJECT 12 THUMBNAIL --><!-- OUTPUT 31 --><img class="output" src="../img/login/thumbnails/12.jpg" style="width:100%;"></td>
						</tr>
				</table>
	
				<!-- a1_b1_c12 TABLE -->
				
				<table id="a1_b1_c12_table" class="subsubject_table b12" style="width:100%;border-collapse:collapse;">
					
					<!-- LINE 0 -->
					<tr class="b12">	
						
						<!-- BUTTONS -->
									
						<td style="border-left-style:none;text-align:center;position:relative;">
							<div style="margin:auto;text-align:center;">
								<table style="width:100%;">
									<tr>
										
										<td style="width:100%;">
											<div style="width:100%;float:right;">
												<button id="play_icon_a1_b1_c12" class="responsive_input_4 button" style="width:100%;">נגן סרטון <i class="fa fa-play-circle-o" style="font-size:16px;"></i></button>
											</div>
										</td>	
										
									</tr>
								</table>
									
								<div style="width:100%;float:right;margin-top:5px;">
									<div style="width:50%;margin:auto;">
										<hr>
									</div>
								</div>
						
							</div>
						</td>
					</tr>
					
					<!-- LINE 1 -->
					<tr class="b12">
						
						<!-- HEADLINE -->	
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<h3 style="margin:0px auto;">הערות שלי</h3>
						</td>
					
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b12">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
						
					<!-- LINE 2 -->
				
					<tr class="b12">
						
						<!-- TEXT -->
						<td>
							<u>טקסט</u>
						</td>
					</tr>
					
					<!-- LINE 3 -->
				
					<tr class="b12">
						
						<!-- TEXTAREA -->
						<td>
							<textarea id="textarea_a1_b1_c12" style="width:100%;height:100px;" placeholder="למשל: לא הבנתי את מה שהלך בדקה השניה..."></textarea>
						</td>
					</tr>
			
			
					<!-- LINE 4 -->
			
					<tr class="b12">
										
						<!-- 2 BUTTONS -->
						<td style="text-align:center;position:relative;">
						
							<!-- BUTTON -->
							<div id="clear_colors_a1_b1_c12" style="width:49%;margin:auto;" class="responsive_input_4 button">
								אפס צבעים
							</div>
										
							<!-- BUTTON -->
							<div id="save_button_a1_b1_c12" style="width:49%;margin:auto;" class="responsive_input_4 button">
								שמור
							</div>
						</td>
					</tr>
			
					<!-- LINE 5 -->
			
					<tr class="b12">
						
						<!-- HORIZONTAL LINE -->
						<td style="height:10px;text-align:center;position:relative;">
							<!-- HR -->
							<div style="width:50%;margin:auto;">
								<hr style="margin-top:10px;">
							</div>
						</td>
					</tr>
			
					<!-- LINE 6 -->
			
					<tr class="b12">
						
						<!-- לסיכום -->				
						<td style="border-left-style:none;text-align:center;position:relative;">
							<h4 style="margin:6px auto;"><b>לסיכום</b></h4>
						</td>
					</tr>
			
					<!-- LINE 7 -->
			
					<tr class="b12">
						
						<!-- 2 BUTTONS -->			
						<td style="text-align:center;position:relative;">
							<!-- BUTTON -->
							<div id="gotit_a1_b1_c12" style="width:49%;margin:auto;" class="responsive_input_4 button">
								הבנתי
							</div>
										
							<!-- BUTTON -->
							<div id="dgetit_a1_b1_c12" style="width:49%;margin:auto;" class="responsive_input_4 button">
								לא הבנתי
							</div>
						</td>
					</tr>
					
					<!-- HORIZONTAL LINE -->
					<tr class="b12">
						<td style="border-left-style:none;text-align:center;position:relative;float:right;width:100%;margin:10px;">
							<div style="width:100%;margin-top:0px;text-align:center;">
								<div style="width:50%;margin:auto;">
									<hr>
								</div>
							</div>
						</td>
					</tr>
				</table><!-- END OF a1_b1_c12 -->		
	
		<div id="div_table_drills_2" style="width:100%;margin:auto;float:right;"></div>
					
	<!-- FOOTER -->    
		<footer id="footer_1" style="float:right;clear:both;margin-top:12px;">
			<a href="https://1000ish.com">
				<div style="width:100%;">
					<img style="width:100%;" src="../img/practice/practice.jpg"/>
				</div>
			</a>
		</footer>
	</div>
	
	<div id="disqus_thread"></div>
	<script>
	
	/**
	*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
	*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
	
	var disqus_config = function () {
	this.page.url = 'https://course006.explainit.online';  // Replace PAGE_URL with your page's canonical URL variable
	this.page.identifier = 'index'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
	};
	
	(function() { // DON'T EDIT BELOW THIS LINE
	var d = document, s = d.createElement('script');
	s.src = 'https://https-course006-explainit-online.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
	})();
	</script>
	<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                            
	
	<!-- FUNCS -->
	<script>
	//FUNCTION TO CHECK IF ALL SUBJECTS IN PART WERE UNDERSTOOD
	//- GETS PART NUMBER.
	//- CHECKS IF ALL SUBJECTS INCLUDE "GOT_IT" CLASS.
	//- CHANGES PART PIC IF YES.
	function check_part(part_number)
	{
		//SETTING COUNTER TO 0
		var counter = 0;
		
		//PART 1 IS CHECKED
		if(part_number == 1)
		{
			//CHECKING SUBJECT 01
			var classList = document.getElementById("b1_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 01
			
			//CHECKING SUBJECT 02
			var classList = document.getElementById("b2_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 02
			
			//CHECKING SUBJECT 03
			var classList = document.getElementById("b3_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 03
			
			//CHECKING SUBJECT 04
			var classList = document.getElementById("b4_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 04
			
			//CHECKING SUBJECT 05
			var classList = document.getElementById("b5_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 05
			
							
			if(counter == 5)//ALL SUBJECTS INCLUDE GOT_IT CLASS
			{
				//CHANGE PART IMG
				$("#b0_1").html('<img class="output" src="../img/table/08.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
			
		}//CHECKING PART 1
		
		//CHECKING PART 2
		else if (part_number == 2)
		{
			
			//CHECKING SUBJECT 06
			var classList = document.getElementById("b6_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 06
			
			
			//CHECKING SUBJECT 07
			var classList = document.getElementById("b7_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 07
			
			//CHECKING SUBJECT 08
			var classList = document.getElementById("b8_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 08
			
			if(counter == 3)//ALL SUBJECTS INCLUDE GOT_IT CLASS
			{
				//CHANGE PART IMG
				$("#b01_1").html('<img class="output" src="../img/table/11.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
		}//CHECKING PART 2
		
		//CHECKING PART 3
		else if (part_number == 3)
		{
					
			//CHECKING SUBJECT 09
			var classList = document.getElementById("b9_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 09
			
			//CHECKING SUBJECT 10
			var classList = document.getElementById("b10_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 10
						
			//CHECKING SUBJECT 11
			var classList = document.getElementById("b11_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 11
			
			
			//CHECKING SUBJECT 12
			var classList = document.getElementById("b12_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "GOT_IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'got_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 12
			
			if(counter == 4)//ALL SUBJECTS INCLUDE GOT_IT CLASS
			{
				//CHANGE PART IMG
				$("#b02_1").html('<img class="output" src="../img/table/12.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
		}//CHECKING PART 3
	}//FUNCTION CHECK_PART

	//FUNCTION TO CHECK IF AT LEAST ONE SUBJECT IN PART WASN'T UNDERSTOOD
	//- GETS PART NUMBER.
	//- CHECKS IF AT LEAST ONE SUBJECT INCLUDES "DIDNT_GET_IT" CLASS.
	//- CHANGES PART PIC IF FOUND AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD.
	function check_part_2(part_number)
	{
		//SETTING COUNTER TO 0
		var counter = 0;
		
		//PART 1 IS CHECKED
		if(part_number == 1)
		{
			//CHECKING SUBJECT 01
			var classList = document.getElementById("b1_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 01
			
			//CHECKING SUBJECT 02
			var classList = document.getElementById("b2_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 02
			
			//CHECKING SUBJECT 03
			var classList = document.getElementById("b3_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 03
			
			//CHECKING SUBJECT 04
			var classList = document.getElementById("b4_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 04
			
			//CHECKING SUBJECT 05
			var classList = document.getElementById("b5_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 05
				
			if(counter > 0)//AT LEAST ONE SUBJECT WASN'T UNDERSTOOD
			{
				//CHANGE PART IMG
				$("#b0_1").html('<img class="output" src="../img/table/04.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
			else//ALL SUBJECTS UNDERSTOOD/NOT COLORED
			{
				//CHANGE PART IMG
				$("#b0_1").html('<img class="output" src="../img/table/01.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
			
		}//CHECKING PART 1
		
		//CHECKING PART 2
		else if (part_number == 2)
		{
			
			//CHECKING SUBJECT 06
			var classList = document.getElementById("b6_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 06
			
			
			//CHECKING SUBJECT 07
			var classList = document.getElementById("b7_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 07
			
			//CHECKING SUBJECT 08
			var classList = document.getElementById("b8_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 08
			
			if(counter > 0)//AT LEAST ONE SUBJECT WASN'T UNDERSTOOD
			{
				//CHANGE PART IMG
				$("#b01_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
			else//ALL SUBJECTS UNDERSTOOD/NOT COLORED
			{
				//CHANGE PART IMG
				$("#b01_1").html('<img class="output" src="../img/table/02.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
		}//CHECKING PART 2
		
		//CHECKING PART 3
		else if (part_number == 3)
		{
			//CHECKING SUBJECT 09
			var classList = document.getElementById("b9_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 09
			
			//CHECKING SUBJECT 10
			var classList = document.getElementById("b10_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 10
			
			//CHECKING SUBJECT 11
			var classList = document.getElementById("b11_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 11
						
			//CHECKING SUBJECT 12
			var classList = document.getElementById("b12_1").className.split(/\s+/);
			
			//LOOP THROUGH CLASSES TO FIND "DIDN'T GET IT"
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'didnt_get_it') 
				{
					//ADDING 1 TO COUNTER
					counter++;
					
					//BREAKING
					break;
				}
			}//SUBJECT 12
						
			if(counter > 0)//AT LEAST ONE SUBJECT WASN'T UNDERSTOOD
			{
				//CHANGE PART IMG
				$("#b02_1").html('<img class="output" src="../img/table/06.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
			else//ALL SUBJECTS UNDERSTOOD/NOT COLORED
			{
				//CHANGE PART IMG
				$("#b02_1").html('<img class="output" src="../img/table/03.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
			}
		}//CHECKING PART 3	
	}//FUNCTION CHECK_PART_2
		
	
	<!-- cl script cl.js -->
	function cl(str,variable)
	{
		//console.log(str,variable);
	}
			
	<!-- a_11_f script -->
	// loader window resize function
	function a_11_f()
	{
		//console.log("---a 11 f")
		
		var a_11_loader = $(document.body).outerWidth()/2-60;
		//console.log(a_11_loader);
		var a_12_loader = $(window).outerHeight()/2-60;
		//*$('.loader').css("left",a_11_loader);
		$('.loader').css("left","40%");
		$('.loader').css("top",a_12_loader);
	}
	
	<!-- CHECK CLASS -->
	function check_class(id)
	{
		
		var classList = document.getElementById(id).className.split(/\s+/);
		var counter = 0;
		
		for (var i = 0; i < classList.length; i++)
		{
			if (classList[i] == 'clicked') 
			{
				$('#'+id).addClass('unclicked');
				$('#'+id).removeClass('clicked');
				
				break;
			}
			else
			{
				counter++;
			}
		}
		
		if( counter == classList.length)
		{
			$('#'+id).addClass('clicked');
			$('#'+id).removeClass('unclicked');
		}
	}
	
	<!-- DOCUMENT READY SCRIPT -->
	$(document).ready(function()
	{
		//SETTING CLICKS//POST REQUEST//OUTPUT 32
		$.post("metal_2_videos.php",
		{
		string_1:"<?= $_SERVER['REMOTE_ADDR']?>",
		number_1:"12"	,
		v_0:"<?= $v[0]; ?>",
		v_1:"<?= $v[1]; ?>",
		v_2:"<?= $v[2]; ?>",
		v_3:"<?= $v[3]; ?>",
		v_4:"<?= $v[4]; ?>",
		v_5:"<?= $v[5]; ?>",
		v_6:"<?= $v[6]; ?>",
		v_7:"<?= $v[7]; ?>",
		v_8:"<?= $v[8]; ?>",
		v_9:"<?= $v[9]; ?>",
		},
		function(data, status, example_var)
		{
			//GETTING HTML
			$("#div_table_drills_2").html(data);
					
			//CLICK//? NEEDED
			$("#td_click").click(function()
			{
				$(".td_click").toggle();
			});
			
			//GET CURRENT COMMENTS
			//GET CURRENT VIEWS
			//GET CURRENT COLORS
				
				//GETTING CURRENT COMMENTS STATUS//ALL//OUTPUT 33 
				$.post("metal_6_h_videos.php",
				{
					subject_1:"all",
					question_1:"all",
				},
				function(data, status)
				{
					var result_1 = JSON.parse(data);
					//console.log("comments:",result_1);
					//UPDATE									
					//UPDATING TEXTAREA
					
					//RESULT ARRAY IS EMPTY
					if(result_1 === null)
					{
						//console.log("no comments");
					}//RESULT ARRAY IS EMPTY
					
					//RESULT ARRAY ISN'T EMPTY
					else
					{
						$("#textarea_a1_b1_c1").val(result_1["Q1"]);
						$("#textarea_a1_b1_c2").val(result_1["Q2"]);
						$("#textarea_a1_b1_c3").val(result_1["Q3"]);
						$("#textarea_a1_b1_c4").val(result_1["Q4"]);
						$("#textarea_a1_b1_c5").val(result_1["Q5"]);
						$("#textarea_a1_b1_c6").val(result_1["Q6"]);
						$("#textarea_a1_b1_c7").val(result_1["Q7"]);
						$("#textarea_a1_b1_c8").val(result_1["Q8"]);
						$("#textarea_a1_b1_c9").val(result_1["Q9"]);
						$("#textarea_a1_b1_c10").val(result_1["Q10"]);
						$("#textarea_a1_b1_c11").val(result_1["Q11"]);
						$("#textarea_a1_b1_c12").val(result_1["Q12"]);
										
					}//RESULT ARRAY ISN'T EMPTY
				});//END OF GETTING COMMENTS STATUS//ALL
										
				//GETTING CURRENT VIEWS STATUS//ALL//OUTPUT 34 
				$.post("metal_6_g_videos.php",
				{
					subject_1:"all",
					question_1:"all",
				},
				function(data, status)
				{
					var result_1 = JSON.parse(data);
					//console.log("views:",result_1);
		
				//UPDATE//CASES
					//$("#a1_b1_c1_views").html("("+result_1['Q1']+" "+"צפיות"+")").promise().done(function(){
					//NOTHING DONE AT THE MOMENT
					//});

					//VIEWS ARRAY IS EMPTY
					if(result_1 === null)
					{
						//console.log("no views");
					}//VIEWS ARRAY IS EMPTY
					
					//VIEWS ARRAY ISN'T EMPTY
					else
					{		
						$("#a1_b1_c1_views").html("("+result_1['Q1']+" "+"צפיות"+")");
						$("#a1_b1_c2_views").html("("+result_1['Q2']+" "+"צפיות"+")");
						$("#a1_b1_c3_views").html("("+result_1['Q3']+" "+"צפיות"+")");
						$("#a1_b1_c4_views").html("("+result_1['Q4']+" "+"צפיות"+")");
						$("#a1_b1_c5_views").html("("+result_1['Q5']+" "+"צפיות"+")");
						$("#a1_b1_c6_views").html("("+result_1['Q6']+" "+"צפיות"+")");
						$("#a1_b1_c7_views").html("("+result_1['Q7']+" "+"צפיות"+")");
						$("#a1_b1_c8_views").html("("+result_1['Q8']+" "+"צפיות"+")");
						$("#a1_b1_c9_views").html("("+result_1['Q9']+" "+"צפיות"+")");
						$("#a1_b1_c10_views").html("("+result_1['Q10']+" "+"צפיות"+")");
						$("#a1_b1_c11_views").html("("+result_1['Q11']+" "+"צפיות"+")");
						$("#a1_b1_c12_views").html("("+result_1['Q12']+" "+"צפיות"+")");
						
					}//VIEWS ARRAY ISN'T EMPTY
				});
				//END OF GETTING VIEWS STATUS//ALL
				
				//GETTING CURRENT COLORS STATUS//ALL//OUTPUT 35
				$.post("metal_6_i_videos.php",
				{
					subject_1:"all",
					question_1:"all",
				},
				function(data, status)
				{
					var result_1 = JSON.parse(data);
					//console.log("colors:",result_1);
					//UPDATE//CASES//a1_b1_c1
					
					//COLORS ARRAY IS EMPTY
					if(result_1 === null)
					{
						//console.log("no colors");
					}//COLORS ARRAY IS EMPTY
					
					//COLORS ARRAY ISN'T EMPTY
					else
					{
					
						if(result_1["Q1"] == 1)
						{
							//MAIN
							$(".a1_b1_c1_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c1").css("background-color","green");
						}
						if(result_1["Q1"] == 2)
						{
							//MAIN
							$(".a1_b1_c1_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c1").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c2
						
						if(result_1["Q2"] == 1)
						{
							//MAIN
							$(".a1_b1_c2_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c2").css("background-color","green");
						}
						if(result_1["Q2"] == 2)
						{
							//MAIN
							$(".a1_b1_c2_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c2").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c3
						
						if(result_1["Q3"] == 1)
						{
							//MAIN
							$(".a1_b1_c3_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c3").css("background-color","green");
						}
						if(result_1["Q3"] == 2)
						{
							//MAIN
							$(".a1_b1_c3_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c3").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c4
						
						if(result_1["Q4"] == 1)
						{
							//MAIN
							$(".a1_b1_c4_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c4").css("background-color","green");
						}
						if(result_1["Q4"] == 2)
						{
							//MAIN
							$(".a1_b1_c4_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c4").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c5
						
						if(result_1["Q5"] == 1)
						{
							//MAIN
							$(".a1_b1_c5_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c5").css("background-color","green");
						}
						if(result_1["Q5"] == 2)
						{
							//MAIN
							$(".a1_b1_c5_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c5").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c6
						
						if(result_1["Q6"] == 1)
						{
							//MAIN
							$(".a1_b1_c6_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c6").css("background-color","green");
						}
						if(result_1["Q6"] == 2)
						{
							//MAIN
							$(".a1_b1_c6_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c6").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c7
						
						if(result_1["Q7"] == 1)
						{
							//MAIN
							$(".a1_b1_c7_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c7").css("background-color","green");
						}
						if(result_1["Q7"] == 2)
						{
							//MAIN
							$(".a1_b1_c7_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c7").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c8
						
						if(result_1["Q8"] == 1)
						{
							//MAIN
							$(".a1_b1_c8_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c8").css("background-color","green");
						}
						if(result_1["Q8"] == 2)
						{
							//MAIN
							$(".a1_b1_c8_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c8").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c9
						
						if(result_1["Q9"] == 1)
						{
							//MAIN
							$(".a1_b1_c9_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c9").css("background-color","green");
						}
						if(result_1["Q9"] == 2)
						{
							//MAIN
							$(".a1_b1_c9_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c9").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c1
						
						if(result_1["Q10"] == 1)
						{
							//MAIN
							$(".a1_b1_c10_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c10").css("background-color","green");
						}
						if(result_1["Q10"] == 2)
						{
							//MAIN
							$(".a1_b1_c10_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c10").css("background-color","red");
						}
						//UPDATE//CASES//a1_b1_c11
						
						if(result_1["Q11"] == 1)
						{
							//MAIN
							$(".a1_b1_c11_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c11").css("background-color","green");
						}
						if(result_1["Q11"] == 2)
						{
							//MAIN
							$(".a1_b1_c11_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c11").css("background-color","red");
						}
						
						//UPDATE//CASES//a1_b1_c12
						
						if(result_1["Q12"] == 1)
						{
							//MAIN
							$(".a1_b1_c12_main").addClass("got_it");
								
							//BUTTON
							$("#gotit_a1_b1_c12").css("background-color","green");
						}
						if(result_1["Q12"] == 2)
						{
							//MAIN
							$(".a1_b1_c12_main").addClass("didnt_get_it");
							
							//BUTTON
							$("#dgetit_a1_b1_c12").css("background-color","red");
						}//UPDATE//CASES//a1_b1_c12
						
						//CHECKING IF THERE WAS AT LEAST ONE SUBJECT IN PART THAT WASN'T UNDERSTOOD
						check_part_2(1);
						check_part_2(2);
						check_part_2(3);
												
						//CHECKING IF THERE ARE PARTS THAT HAVE BEEN FULLY UNDERSTOOD
						check_part(1);
						check_part(2);
						check_part(3);
					
					}//COLORS ARRAY ISN'T EMPTY
				});
				//END OF GETTING COLORS STATUS//ALL
				
				//PLAY ICON a1_b1_c1
				$(document).on("click touchstart", "#play_icon_a1_b1_c1", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_1
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q1",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c1").click(); }, 1000);
				});//PLAY ICON a1_b1_c1	
				
				//PLAY ICON a1_b1_c2
				$(document).on("click touchstart", "#play_icon_a1_b1_c2", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_2 
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q2",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c2").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c3
				$(document).on("click touchstart", "#play_icon_a1_b1_c3", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_3
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q3",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c3").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c4
				$(document).on("click touchstart", "#play_icon_a1_b1_c4", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_4 
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q4",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c4").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c5
				$(document).on("click touchstart", "#play_icon_a1_b1_c5", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_5
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q5",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c5").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c6
				$(document).on("click touchstart", "#play_icon_a1_b1_c6", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_6 
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q6",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c6").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c7
				$(document).on("click touchstart", "#play_icon_a1_b1_c7", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_7
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q7",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c7").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c8
				$(document).on("click touchstart", "#play_icon_a1_b1_c8", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_8 
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q8",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c8").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c9
				$(document).on("click touchstart", "#play_icon_a1_b1_c9", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_9
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q9",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c9").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c10
				$(document).on("click touchstart", "#play_icon_a1_b1_c10", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_10
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q10",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c10").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c11
				$(document).on("click touchstart", "#play_icon_a1_b1_c11", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_11 
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q11",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c11").click(); }, 1000);
				});	
				
				//PLAY ICON a1_b1_c12
				$(document).on("click touchstart", "#play_icon_a1_b1_c12", 
				function ()
				{
					//UPDATING PLAYS NUMBER//SINGLE//OUTPUT 36_12 
					$.post("metal_6_d_videos.php",
					{
						subject_1:"a1",
						question_1:"Q12",
					},
					function(data, status)
					{
						//console.log('OK');
					});	//END OF UPDATING VIEWS POST REQUEST
				
					//CLICKING PLAY
					setTimeout(function(){ $("#input_08_a1_b1_c12").click(); }, 1000);
				});	
									
				//GOT IT/DIDN'T GET IT//A1
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c1").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c1_main").removeClass("didnt_get_it");
					$(".a1_b1_c1_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c1").css("background-color","#a9014b");
					$("#gotit_a1_b1_c1").css("background-color","green");
					
					//UPDATING SUBJECT PIC
					$("#td_pic_01").html('<img class="output" src="../img/login/thumbnails/good_job_01.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(1);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(1);
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 37_1
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q1",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c2
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c2").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c2_main").removeClass("didnt_get_it");
					$(".a1_b1_c2_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c2").css("background-color","#a9014b");
					$("#gotit_a1_b1_c2").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_02").html('<img class="output" src="../img/login/thumbnails/good_job_02.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(1);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(1);
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 37_2
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q2",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c3
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c3").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c3_main").removeClass("didnt_get_it");
					$(".a1_b1_c3_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c3").css("background-color","#a9014b");
					$("#gotit_a1_b1_c3").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_03").html('<img class="output" src="../img/login/thumbnails/good_job_03.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(1);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(1);
						
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 37_3
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q3",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c4
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c4").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c4_main").removeClass("didnt_get_it");
					$(".a1_b1_c4_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c4").css("background-color","#a9014b");
					$("#gotit_a1_b1_c4").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_04").html('<img class="output" src="../img/login/thumbnails/good_job_04.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(1);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(1);
					
					//UPDATING NEW COLOR//A1_B1_C4//OUTPUT 37_4
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q4",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c5
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c5").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c5_main").removeClass("didnt_get_it");
					$(".a1_b1_c5_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c5").css("background-color","#a9014b");
					$("#gotit_a1_b1_c5").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_05").html('<img class="output" src="../img/login/thumbnails/good_job_05.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(1);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(1);
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 37_5
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q5",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c6
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c6").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c6_main").removeClass("didnt_get_it");
					$(".a1_b1_c6_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c6").css("background-color","#a9014b");
					$("#gotit_a1_b1_c6").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_06").html('<img class="output" src="../img/login/thumbnails/good_job_06.jpg" style="width:100%;">');
									
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(2);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(2);
					
					//UPDATING NEW COLOR//A1_B1_C6//OUTPUT 37_6
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q6",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c7
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c7").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c7_main").removeClass("didnt_get_it");
					$(".a1_b1_c7_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c7").css("background-color","#a9014b");
					$("#gotit_a1_b1_c7").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_07").html('<img class="output" src="../img/login/thumbnails/good_job_07.jpg" style="width:100%;">');
										
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(2);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(2);
					
					//UPDATING NEW COLOR//A1_B1_C7//OUTPUT 37_7
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q7",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c8
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c8").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c8_main").removeClass("didnt_get_it");
					$(".a1_b1_c8_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c8").css("background-color","#a9014b");
					$("#gotit_a1_b1_c8").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_08").html('<img class="output" src="../img/login/thumbnails/good_job_08.jpg" style="width:100%;">');
						
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(2);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(2);
					
					//UPDATING NEW COLOR//A1_B1_C8//OUTPUT 37_8
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q8",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c9
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c9").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c9_main").removeClass("didnt_get_it");
					$(".a1_b1_c9_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c9").css("background-color","#a9014b");
					$("#gotit_a1_b1_c9").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_09").html('<img class="output" src="../img/login/thumbnails/good_job_09.jpg" style="width:100%;">');
										
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(3);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(3);
					
					//UPDATING NEW COLOR//A1_B1_C9//OUTPUT 37_9
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q9",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c10
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c10").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c10_main").removeClass("didnt_get_it");
					$(".a1_b1_c10_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c10").css("background-color","#a9014b");
					$("#gotit_a1_b1_c10").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_10").html('<img class="output" src="../img/login/thumbnails/good_job_10.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(3);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(3);
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 37_10
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q10",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//A1
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c11").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c11_main").removeClass("didnt_get_it");
					$(".a1_b1_c11_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c11").css("background-color","#a9014b");
					$("#gotit_a1_b1_c11").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_11").html('<img class="output" src="../img/login/thumbnails/good_job_11.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(3);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(3);
					
					//UPDATING NEW COLOR//A1_B1_C11//OUTPUT 37_11
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q11",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF gotit_a1 CLICK
				
				//GOT IT/DIDN'T GET IT//a1_b1_c12
				//CHANGE VALUE UPON CLICK
				$("#gotit_a1_b1_c12").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c12_main").removeClass("didnt_get_it");
					$(".a1_b1_c12_main").addClass("got_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c12").css("background-color","#a9014b");
					$("#gotit_a1_b1_c12").css("background-color","green");
																			
					//UPDATING SUBJECT PIC
					$("#td_pic_12").html('<img class="output" src="../img/login/thumbnails/good_job_12.jpg" style="width:100%;">');
					
					//CHECKING IF THERE WAS AT LEAST ONE SUBJECT THAT WASN'T UNDERSTOOD
					check_part_2(3);
					
					//CHECKING IF ALL SUBJECTS WERE UNDERSTOOD
					check_part(3);
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 37_12
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q12",
						value_1:"1",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});
				
				$("#dgetit_a1_b1_c1").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c1_main").removeClass("got_it");
					$(".a1_b1_c1_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c1").css("background-color","red");
					$("#gotit_a1_b1_c1").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b0_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_01").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 38_1
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q1",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c2").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c2_main").removeClass("got_it");
					$(".a1_b1_c2_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c2").css("background-color","red");
					$("#gotit_a1_b1_c2").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b0_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_02").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
										
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 38_2
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q2",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c3").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c3_main").removeClass("got_it");
					$(".a1_b1_c3_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c3").css("background-color","red");
					$("#gotit_a1_b1_c3").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b01_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_03").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C3//OUTPUT 38_3 
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q3",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c4").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c4_main").removeClass("got_it");
					$(".a1_b1_c4_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c4").css("background-color","red");
					$("#gotit_a1_b1_c4").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b01_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_04").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C4//OUTPUT 38_4
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q4",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c5").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c5_main").removeClass("got_it");
					$(".a1_b1_c5_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c5").css("background-color","red");
					$("#gotit_a1_b1_c5").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_05").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C5//OUTPUT 38_5 
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q5",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c6").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c6_main").removeClass("got_it");
					$(".a1_b1_c6_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c6").css("background-color","red");
					$("#gotit_a1_b1_c6").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_06").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
									
					//UPDATING NEW COLOR//A1_B1_C6//OUTPUT 38_6
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q6",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c7").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c7_main").removeClass("got_it");
					$(".a1_b1_c7_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c7").css("background-color","red");
					$("#gotit_a1_b1_c7").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_07").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
										
					//UPDATING NEW COLOR//A1_B1_C7//OUTPUT 38_7
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q7",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c8").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c8_main").removeClass("got_it");
					$(".a1_b1_c8_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c8").css("background-color","red");
					$("#gotit_a1_b1_c8").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_08").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
										
					//UPDATING NEW COLOR//A1_B1_C8//OUTPUT 38_8
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q8",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c9").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c9_main").removeClass("got_it");
					$(".a1_b1_c9_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c9").css("background-color","red");
					$("#gotit_a1_b1_c9").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_09").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
										
					//UPDATING NEW COLOR//A1_B1_C9//OUTPUT 38_9
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q9",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c10").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c10_main").removeClass("got_it");
					$(".a1_b1_c10_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c10").css("background-color","red");
					$("#gotit_a1_b1_c10").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_10").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C10//OUTPUT 38_10
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q10",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c11").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c11_main").removeClass("got_it");
					$(".a1_b1_c11_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c11").css("background-color","red");
					$("#gotit_a1_b1_c11").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/05.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_11").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C11//OUTPUT 38_11
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q11",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				$("#dgetit_a1_b1_c12").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c12_main").removeClass("got_it");
					$(".a1_b1_c12_main").addClass("didnt_get_it");
										
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c12").css("background-color","red");
					$("#gotit_a1_b1_c12").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					$("#b02_1").html('<img class="output" src="../img/table/06.jpg" style="margin-bottom:0px;margin-top:0px;width:100%;">');
					
					//UPDATING SUBJECT PIC
					$("#td_pic_12").html('<img class="output" src="../img/login/thumbnails/mail.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C12//OUTPUT 38_12
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q12",
						value_1:"2",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF dgetit_a1 CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c1").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c1_main").removeClass("got_it");
					$(".a1_b1_c1_main").removeClass("didnt_get_it");
					$(".a1_b1_c1_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c1").css("background-color","#a9014b");
					$("#gotit_a1_b1_c1").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(1);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_01").html('<img class="output" src="../img/login/thumbnails/01.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 39_1
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q1",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c2").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c2_main").removeClass("got_it");
					$(".a1_b1_c2_main").removeClass("didnt_get_it");
					$(".a1_b1_c2_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c2").css("background-color","#a9014b");
					$("#gotit_a1_b1_c2").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(1);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_02").html('<img class="output" src="../img/login/thumbnails/02.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C2//OUTPUT 39_2
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q2",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c3").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c3_main").removeClass("got_it");
					$(".a1_b1_c3_main").removeClass("didnt_get_it");
					$(".a1_b1_c3_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c3").css("background-color","#a9014b");
					$("#gotit_a1_b1_c3").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(1);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_03").html('<img class="output" src="../img/login/thumbnails/03.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C3//OUTPUT 39_3
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q3",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c4").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c4_main").removeClass("got_it");
					$(".a1_b1_c4_main").removeClass("didnt_get_it");
					$(".a1_b1_c4_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c4").css("background-color","#a9014b");
					$("#gotit_a1_b1_c4").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(1);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_04").html('<img class="output" src="../img/login/thumbnails/04.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C1//OUTPUT 39_4
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q4",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c5").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c5_main").removeClass("got_it");
					$(".a1_b1_c5_main").removeClass("didnt_get_it");
					$(".a1_b1_c5_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c5").css("background-color","#a9014b");
					$("#gotit_a1_b1_c5").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(1);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_05").html('<img class="output" src="../img/login/thumbnails/05.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C5//OUTPUT 39_5
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q5",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c6").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c6_main").removeClass("got_it");
					$(".a1_b1_c6_main").removeClass("didnt_get_it");
					$(".a1_b1_c6_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c6").css("background-color","#a9014b");
					$("#gotit_a1_b1_c6").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(2);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_06").html('<img class="output" src="../img/login/thumbnails/06.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C6//OUTPUT 39_6
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q6",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c7").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c7_main").removeClass("got_it");
					$(".a1_b1_c7_main").removeClass("didnt_get_it");
					$(".a1_b1_c7_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c7").css("background-color","#a9014b");
					$("#gotit_a1_b1_c7").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(2);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_07").html('<img class="output" src="../img/login/thumbnails/07.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C7//OUTPUT 39_7
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q7",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c8").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c8_main").removeClass("got_it");
					$(".a1_b1_c8_main").removeClass("didnt_get_it");
					$(".a1_b1_c8_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c8").css("background-color","#a9014b");
					$("#gotit_a1_b1_c8").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(2);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_08").html('<img class="output" src="../img/login/thumbnails/08.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C8//OUTPUT 39_8
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q8",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c9").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c9_main").removeClass("got_it");
					$(".a1_b1_c9_main").removeClass("didnt_get_it");
					$(".a1_b1_c9_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c9").css("background-color","#a9014b");
					$("#gotit_a1_b1_c9").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(3);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_09").html('<img class="output" src="../img/login/thumbnails/09.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C9//OUTPUT 39_9
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q9",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS
				$("#clear_colors_a1_b1_c10").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c10_main").removeClass("got_it");
					$(".a1_b1_c10_main").removeClass("didnt_get_it");
					$(".a1_b1_c10_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c10").css("background-color","#a9014b");
					$("#gotit_a1_b1_c10").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(3);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_10").html('<img class="output" src="../img/login/thumbnails/10.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C10//OUTPUT 39_10
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q10",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS//A1
				$("#clear_colors_a1_b1_c11").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c11_main").removeClass("got_it");
					$(".a1_b1_c11_main").removeClass("didnt_get_it");
					$(".a1_b1_c11_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c11").css("background-color","#a9014b");
					$("#gotit_a1_b1_c11").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(3);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_11").html('<img class="output" src="../img/login/thumbnails/11.jpg" style="width:100%;">');
						
					//UPDATING NEW COLOR//A1_B1_C11//OUTPUT 39_11
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q11",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors CLICK
				
				//CLEAR COLORS a1_b1_c12
				$("#clear_colors_a1_b1_c12").click(function()
				{
					//LOCAL COLORS//MAIN
					$(".a1_b1_c12_main").removeClass("got_it");
					$(".a1_b1_c12_main").removeClass("didnt_get_it");
					$(".a1_b1_c12_main").addClass("clicked");
					
					//LOCAL COLORS//BUTTONS
					$("#dgetit_a1_b1_c12").css("background-color","#a9014b");
					$("#gotit_a1_b1_c12").css("background-color","#a9014b");
					
					//UPDATING PART PIC
					check_part_2(3);
					
					//UPDATING SUBJECT PIC
					$("#td_pic_12").html('<img class="output" src="../img/login/thumbnails/12.jpg" style="width:100%;">');
					
					//UPDATING NEW COLOR//A1_B1_C12//OUTPUT 39_12
					$.post("metal_6_f_videos.php",
					{
						subject_1:"a1",
						question_1:"Q12",
						value_1:"0",
					},
					function(data, status)
					{
						if(data == 'OK');
						{
							alert('העדכון בוצע בהצלחה.');
						}
					});//END OF UPDATING NEW COLOR
				});//END OF clear_colors_a1_b1_c12 CLICK
				
				//SAVE//A1
				$("#save_button_a1_b1_c1").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c1").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_1_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q1',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c1").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_1_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q1',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_1_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q1'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c2
				$("#save_button_a1_b1_c2").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c2").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_2_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q2',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c2").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_2_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q2',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_2_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q2'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c3
				$("#save_button_a1_b1_c3").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c3").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_3_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q3',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c3").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_3_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q3',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_3_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q3'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c4
				$("#save_button_a1_b1_c4").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c4").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_4_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q4',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c4").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_4_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q4',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_4_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q4'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c5
				$("#save_button_a1_b1_c5").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c5").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_5_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q5',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c5").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_5_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q5',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_5_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q5'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//A1
				$("#save_button_a1_b1_c6").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c6").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_6_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q6',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c6").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_6_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q6',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_6_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q6'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c7
				$("#save_button_a1_b1_c7").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c7").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_7_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q7',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c7").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_7_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q7',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_7_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q7'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c8
				$("#save_button_a1_b1_c8").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c8").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_8_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q8',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c8").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_8_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q8',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_8_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q8'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c9
				$("#save_button_a1_b1_c9").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c9").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_9_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q9',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c9").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_9_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q9',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_9_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q9'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//A1
				$("#save_button_a1_b1_c10").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c10").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_10_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q10',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c10").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_10_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q10',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_10_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q10'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c11
				$("#save_button_a1_b1_c11").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c11").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_11_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q11',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c11").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_11_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q11',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_11_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q11'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
				//SAVE//a1_b1_c12
				$("#save_button_a1_b1_c12").click(function()
				{
					//SANITIZING FUNCTIONS
					function escapeRegExp(string)
					{
						//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
						string = string.replace("script", "scipbt"); 
						string = string.replace("'", "`"); 
						return string; 
					}
					
					//COMPARING CURRENT & NEW COMMENTS
					function check_current_comment(result)							
					{
						//VARS
						var current_comment = $("#textarea_a1_b1_c12").val();
						var previous_comment = result;
						
						//CASES
						if (current_comment.length == 0 && previous_comment.length == 0)
						{
							alert("אין מה לעדכן.");
						}
						//BLANK COMMENT UPDATE
						else if (current_comment.length == 0 && previous_comment.length != 0)
						{
							if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
							{
								if(current_comment.length > 1000)
								{
									alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
								}
								else//UPDATING COMMENT TO NEW COMMENT
								{
									//ESCAPING CHARS
									var text_value = escapeRegExp(current_comment);
									
									//INSERT NEW COMMENT//OUTPUT 40_12_1
									$.post("metal_6_videos.php",
									{
										comments_a1: text_value,
										question_1: 'Q12',
									},
									function(data, status)
									{
										alert("ההערה נמחקה בהצלחה.");
									}//END OF POST SUCCESS FUNCTION
									);//END OF POST REQUEST
								}
							}
							else//DOESN'T WANT TO DELETE
							{
								$("#textarea_a1_b1_c12").val(previous_comment);
							}
						}
						else// USUAL COMMENT UPDATE
						{
							if(current_comment.length > 1000)
							{
								alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
							}
							else//UPDATING TO NEW COMMENT
							{
								//ESCAPING CHARS
								var text_value = escapeRegExp(current_comment);
								
								//INSERT NEW COMMENT//OUTPUT 40_12_2
								$.post("metal_6_videos.php",
								{
									comments_a1: text_value,
									question_1: 'Q12',
								},
								function(data, status)
								{
									alert("ההערה נשמרה בהצלחה.");
								}//END OF POST SUCCESS FUNCTION
								);//END OF POST REQUEST
							}//UPDATE END
						}//USUAL UPDATE END
					}//FUNCTION END
					
					//GETTING CURRENT COMMENT//OUTPUT 40_12_3
					$.ajax
					({
						url: 'metal_6_b_videos.php',
						type: 'POST',
						//data: {'Y_n': data_1_js,
						//		'Number_0': num}
						data: {Y_n: 'Q12'}
					}).done(function(result)
					{
						check_current_comment(result); 
					});
				});//END OF SAVE_BUTTON_A1 CLICK
				
			}//SUCCESS FUNCTION AFTER POST REQUEST
		);//POST REQUEST
				
		//B1//CLICKS TO SHOW SUBJECT
		
		$("#b1_1").click(function()
		{
			//TOGGLING DISPLAY
			$(".b1").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
		
		//B2
		
		$("#b2_1").click(function()
		{
			$(".b2").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
			
		//B3
		
		$("#b3_1").click(function()
		{
			$(".b3").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
		
		//B4
		
		$("#b4_1").click(function()
		{
			$(".b4").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
			
		//B5
		
		$("#b5_1").click(function()
		{
			$(".b5").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
			
		//B6
		
		$("#b6_1").click(function()
		{
			$(".b6").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
							
		//B7
		
		$("#b7_1").click(function()
		{
			$(".b7").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
		
		//B8
		
		$("#b8_1").click(function()
		{
			$(".b8").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
		
		//B9
		
		$("#b9_1").click(function()
		{
			$(".b9").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
			
		//B10
		
		$("#b10_1").click(function()
		{
			$(".b10").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
							
		//B11
		
		$("#b11_1").click(function()
		{
			$(".b11").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
		
		//B12
		
		$("#b12_1").click(function()
		{
			$(".b12").toggle();
			
			//CLICK COLOR FUNCTION
			check_class(this.id);
		});
		
		//CLICKS FOR BEGINNING
		$("#b1_1").click();
		$("#b2_1").click();
		$("#b3_1").click();
		$("#b4_1").click();
		$("#b5_1").click();
		$("#b6_1").click();
		$("#b7_1").click();
		$("#b8_1").click();
		$("#b9_1").click();
		$("#b10_1").click();
		$("#b11_1").click();
		$("#b12_1").click();
			
		//REMOVING CLASS CLICKED
		$("#b1_1").removeClass("clicked");
		$("#b2_1").removeClass("clicked");
		$("#b3_1").removeClass("clicked");
		$("#b4_1").removeClass("clicked");
		$("#b5_1").removeClass("clicked");
		$("#b6_1").removeClass("clicked");
		$("#b7_1").removeClass("clicked");
		$("#b8_1").removeClass("clicked");
		$("#b9_1").removeClass("clicked");
		$("#b10_1").removeClass("clicked");
		$("#b11_1").removeClass("clicked");
		$("#b12_1").removeClass("clicked");
				
		// setting Timeout
		setTimeout(function(){ $("#n").click(); }, 1000);
		setTimeout(function(){ $("#div_header_3").click(); }, 1000);
		
		//opacity for loader
		$('#div_header_3, #div_table_drills, #hr_number_1, #footer_1, .a1_b1_index,#middle_content').animate({opacity:1},1000);
		$('.loader').css("display","none");
	});

	<!-- window resize script -->
	$( window ).resize(function() 
	{
		//loader
		a_11_f();
	});
	</script>
	</body>
</html>
<?php
}//USER LOGGEDIN SUCCESSFULLY

//USER HASN'T LOGGEDIN SUCCESSFULLY
else
{
	//REPORT MAIL//OUTPUT 6//MAIL 1
	//ATTRIBUTES
	$f = "registration@explainit.online";
	$f_1="Explainit Online - קורס ".$course_number." - DAA - Logged In Page";
			
	//HEADERS
	$headers = "From: registration@explainit.online\r\n";
	$headers .= "Reply-To:registration@explainit.online\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=utf-8\r\n";
	
	//MESSAGE
	$message = '<html lang="iw" dir="rtl"><body>';
	$message .= '<div style="width:100%;margin:auto;text-align:center;">';
	$message .= '<h4>IP:</h4>';
	$message .= '<h4>'.$_SERVER['REMOTE_ADDR'].'</h4>';
	$message .= "</div>";
	$message .= "</body></html>";
	
	//SENDING
	mail($f,$f_1,$message,$headers);
	
	//REDIRECTED TO ERROR PAGE//OUTPUT 41
	header ("location: ../php/error_fi/error_videos.php");
}
?>