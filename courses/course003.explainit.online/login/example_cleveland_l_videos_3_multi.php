<?php
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
$course_number_="003";

//SESSION VARS	
	$U_name = '';
	$_SESSION['loggedin'] = 0;
	$_SESSION['message_1']='הי,<br> כאן מתחברים';
	$_SESSION["refresh_count"]=3;
	
	//COUNT SESSION VAR
	if(!isset($_SESSION['count']))
	{	
		$_SESSION['count'] = 1;
	}

//FUNCTIONS
	function valid($check)
	{
		//checking length
		if (mb_strlen($check)>=8)
		{
			return TRUE;
		}	
	}
	function check_length($str)
	{
		//checking length
		if (mb_strlen($str)>=8)
		{
			return TRUE;
		}	
	}
	
	//UPDATES USED FIELD TO Y
	function check_num($n,$mail,$U_name,$ip_address,$course_number_)
	{
		//CONNECT TO PAYMENTS DB TO SEE IF NUMBER EXISTS
		//CONNECTING 
			//GET DB DETAILS
				$new_path = 'test_02';
				$db_details = getfile($new_path,12);
				
			//CONNECTING//DATABASE//DATA
			
				$host = $db_details[0];
				$username = $db_details[1];
				$password = $db_details[2];
				$db = $db_details[3];
			
			// creating Connection
			$con = mysqli_connect($host, $username, $password,$db);
			
			// checking Connection
			if($con)
			{
				//echo 'connection ok';
			}
			else
			{
				die('Could not connect: '.mysqli_error($con));
			}
				
			// Selecting Database
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
		//CHECKING IF THIS MAIL HAS BEEN PAID FOR
			
			$sql = "SELECT ID FROM Pay_today_POST_MULTI WHERE BY_MAIL='$mail'";
			$query = mysqli_query($con,$sql);
		
		//THIS MAIL HAS BEEN PAID FOR. EXITING.
		
			if (mysqli_num_rows($query) > 0)// THIS MAIL ALREADY HAS BEEN PAID FOR
			{
				//ATTRIBUTES//OUTPUT 11
				$f = "registration@explainit.online";
				$f_1="Explainit Online - קורס ".$course_number_." - שילמו כבר על המייל הזה";
						
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;">';
				$message .= '<h4>THIS MAIL ALREADY HAS BEEN PAID FOR</h4>';
				$message .= '<h4>מייל:</h4>';
				$message .= '<h4>'.$U_name.'</h4>';
				$message .= '<h4>IP:</h4>';
				$message .= '<h4>'.$ip_address.'</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($f,$f_1,$message,$headers);
									
				//ERROR 8 PAGE//OUTPUT 00
				header ('location: ../php/error_fi/error_videos_8.php');
			}
		
		//THIS MAIL HAS NOT BEEN PAID FOR. 
		//CHECKING IF CONFIRMATION NUMBER WAS RECEIVED FROM TRANZILA
		
			$sql = "SELECT email FROM Pay_today_POST_MULTI WHERE ConfirmationCode = '$n' AND USED = 'N'";
			$query = mysqli_query($con,$sql);
		
		//CONFIRMATION NUMBER FOUND.
		
		if (mysqli_num_rows($query) > 0)
		{	
			//CHECKING IF PAYMENT NUMBER HASN'T ALREADY BEEN USED
			
			$sql = "SELECT email FROM Pay_today_POST_MULTI WHERE ConfirmationCode = '$n' AND USED = 'Y'";
			$query = mysqli_query($con,$sql);
			
			//CONFIRMATION NUMBER ALREADY HAS BEEN USED
			if(mysqli_num_rows($query) > 0)			
			{	
				//SENDING REPORT MAIL TO XO
					//ATTRIBUTES//OUTPUT 11
					$f = "registration@explainit.online";
					$f_1="Explainit Online - קורס ".$course_number_." - השתמשו במספר אישור הזה";
							
					//HEADERS
					$headers = "From: registration@explainit.online\r\n";
					$headers .= "Reply-To:registration@explainit.online\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					
					//MESSAGE
					$message = '<html lang="iw" dir="rtl"><body>';
					$message .= '<div style="width:100%;margin:auto;text-align:center;">';
					$message .= '<h4>CONFIRMATION NUMBER ALREADY HAS BEEN USED</h4>';
					$message .= '<h4>מייל:</h4>';
					$message .= '<h4>'.$U_name.'</h4>';
					$message .= '<h4>IP:</h4>';
					$message .= '<h4>'.$ip_address.'</h4>';
					$message .= "</div>";
					$message .= "</body></html>";
					
					//SENDING
					mail($f,$f_1,$message,$headers);
				
				//REPORT MAIL TO XO SENT.
					
				return(2);
			}
			
			//CONFIRMATION NUMBER VALID.
			
			else
			{	
				//PROBABLY UNNEEDED.
				$sql = "SELECT email FROM Pay_today_POST_MULTI WHERE ConfirmationCode = '$n' AND USED = 'N'";
				$query = mysqli_query($con,$sql);
				$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
				$_SESSION['payed_4_e_mail'] = implode(" ",$row);
							
				//UPDATING USED CONFIRMATION NUMBER
				$sql = "UPDATE Pay_today_POST_MULTI SET USED = 'Y' WHERE ConfirmationCode = '$n'";
				$query = mysqli_query($con,$sql);
				
				//CLOSING CONNECTION
				mysqli_close($con);
						
				return(1);
			}
		}
		
		//CONFIRMATION NUMBER NOT FOUND, CONTACT BY PHONE.
		//SENDING REPORT MAIL TO XO
		
		else
		{
			//ATTRIBUTES//OUTPUT 11
			$f = "registration@explainit.online";
			$f_1="Explainit Online - קורס ".$course_number_." - לא נמצא מספר אישור הזה";
					
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>CONFIRMATION NUMBER WAS NOT FOUND</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$U_name.'</h4>';
			$message .= '<h4>IP:</h4>';
			$message .= '<h4>'.$ip_address.'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
		
			return(2);
		}//CONFIRMATION NUMBER WASN'T FOUND - CONTACT BY PHONE
		
		//REPORT MAIL TO XO SENT.
	
	}//FUNCTION check_num
	
	//UPDATES BY_MAIL FIELD
	function used_num($n,$mail,$U_name,$ip_address,$course_number_)
	{
		//CONNECT TO PAYMENTS DB TO SEE IF NUMBER EXISTS
		//CONNECTING 
			//GET DB DETAILS
				$new_path = 'test_02';
				$db_details = getfile($new_path,12);
				
			//CONNECTING//DATABASE//DATA
			
				$host = $db_details[0];
				$username = $db_details[1];
				$password = $db_details[2];
				$db = $db_details[3];
			
			// creating Connection
			$con = mysqli_connect($host, $username, $password,$db);
			
			// checking Connection
			if($con)
			{
				//echo 'connection ok';
			}
			else
			{
				die('Could not connect: '.mysqli_error($con));
			}
				
			// Selecting Database
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
		//CHECKING IF THIS MAIL HAS BEEN PAID FOR
		
		$sql = "SELECT ID FROM Pay_today_POST_MULTI WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		// THIS MAIL ALREADY HAS BEEN PAID FOR 02, DOUBLE CHECK
		
		if (mysqli_num_rows($query) > 0)
		{
			//SENDING REPORT MAIL TO XO

				//ATTRIBUTES//OUTPUT 11
				$f = "registration@explainit.online";
				$f_1="Explainit Online - קורס ".$course_number_." - שילמו כבר על המייל הזה";
						
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;">';
				$message .= '<h4>THIS MAIL ALREADY HAS BEEN PAID FOR 02</h4>';
				$message .= '<h4>מייל:</h4>';
				$message .= '<h4>'.$U_name.'</h4>';
				$message .= '<h4>IP:</h4>';
				$message .= '<h4>'.$ip_address.'</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($f,$f_1,$message,$headers);
			
			//REPORT MAIL TO XO SENT.			
			//EXITING
				
				//ERROR PAGE 8//OUTPUT 01
				header ('location: ../php/error_fi/error_videos_8.php');
		}
		
		//THIS MAIL HASN'T BEEN PAID FOR.
		
		else
		{
			//SENDING REPORT MAIL TO XO
			
				//ATTRIBUTES//OUTPUT 11
				$f = "registration@explainit.online";
				$f_1="Explainit Online - קורס ".$course_number_." - UPDATING";
						
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;">';
				$message .= '<h4>UPDATING BY MAIL</h4>';
				$message .= '<h4>מייל:</h4>';
				$message .= '<h4>'.$U_name.'</h4>';
				$message .= '<h4>IP:</h4>';
				$message .= '<h4>'.$ip_address.'</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($f,$f_1,$message,$headers);
			
			//REPORT MAIL TO XO SENT.
			//UPDATING USED CONFIRMATION NUMBER
			
				$sql = "UPDATE Pay_today_POST_MULTI SET USED = 'Y',BY_MAIL='$mail' WHERE ConfirmationCode = '$n'";
				$query = mysqli_query($con,$sql);
		
		}//THIS MAIL HASN'T BEEN PAID FOR
		
		//CLOSING CONNECTION
		mysqli_close($con);
	
	}//FUNCTION used_num
	
// VARS
	$_SESSION['message_1']='הי,<br> כאן מתחברים';

// Data
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//CONNECTING
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
	//SANITIZING
	
	$U_name = $con->real_escape_string($_POST['user_name']);
	$P_ass = md5($con->real_escape_string($_POST['pass_word']));
	$Num = $con->real_escape_string($_POST['payment_no']);
		
	//VARS
	$_SESSION['u_n']=$U_name;
	$ip_address=$_SERVER['REMOTE_ADDR'];
		
	//CHECKING COUNT
	if($_SESSION['count']<4)
	{
		$v=check_num($Num,$U_name,$U_name,$ip_address,$course_number_);
		
		//CONFIRMATION NUMBER HAS NOT BEEN USED, AND MAIL HAS NOT BEEN PAID FOR.
		//STARTING LOGIN PROCESS
		if($v == 1)//FOUND CONFIRMATION CODE AND STORED E_MAIL IN SESSION VAR
		{
			if(check_length($P_ass))
			{
				
				//retrieving
				$sql = "SELECT * FROM U_videos WHERE U_M = '$U_name'";
				$query = mysqli_query($con,$sql);
				$row = mysqli_fetch_array($query,MYSQLI_ASSOC);	
				
				//DEBUGGING
				/*
				echo '<pre>';
				var_dump($row);
				echo '<br>';
				//echo $P_ass;
				echo '</pre>';
				*/	
				
				//checking mail
				if (mysqli_num_rows($query) > 0)
				{	
					//checking activation
					if($row['U_AP'] == 1)
					{
						$hi=$row['U_E'];
						$hi_2=$row['U_U'];
												
						$p = $hi_2.$P_ass.$hi;
						$p_2 = md5($p);
									
						$sql = "SELECT 1 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row = mysqli_fetch_array($query,MYSQLI_ASSOC);	
						
						//DEBUGGING
						/*
						echo '<pre>';
						var_dump(mysqli_num_rows($query));
						echo '<br>';
						//echo $P_ass;
						echo '</pre>';
						*/	
						
						if(mysqli_num_rows($query) > 0)
						{
							$sql = "SELECT U_N FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
							$h_g = implode(" ",$row);
							$_SESSION['u_n']=$h_g;
							$_SESSION['u_name']=$U_name;
		
							//DEBUGGING
							/*
							echo '<pre>';
							var_dump($row);
							echo '<br>';
							//echo $P_ass;
							echo '</pre>';
							*/
							
							$_SESSION['message_1'] = "התחברות מוצלחת,";
							$_SESSION['loggedin'] = 1;
							
							$sql = "SELECT U_T1 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							$_SESSION['timestamp'] = implode(" ",$row_1);
							$code_1=$_SESSION['timestamp'];
							
							$sql = "SELECT CODE FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							$code_2 = implode(" ",$row_1);
													
							$sql = "SELECT U_T2 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_2 = mysqli_fetch_array($query,MYSQLI_ASSOC);
	
							//DEBUGGING
							/*
							echo '<pre>';
							var_dump($row_1);
							echo '<br>';
							var_dump($row_2);
							echo '</pre>';
							*/
							
							$_SESSION['dir_01'] = implode(" ",$row_2);
							$_SESSION['directory'] = $_SESSION['dir_01']."-".$_SESSION['timestamp'];
							$directory = $_SESSION['dir_01']."-".$_SESSION['timestamp'];
							$IP=$_SERVER['REMOTE_ADDR'];
							
							//UPDATING LOGS
							//LOGIN TIME
							date_default_timezone_set('Asia/Jerusalem');
							$login_time = time();
							$date_login = date('m/d/Y h:i:s a', time());
													
							//LOGOUT TIME
							date_default_timezone_set('Asia/Jerusalem');
							$logout_time = time()+(3600);//1 hour later
							$date_logout = date('m/d/Y h:i:s a', $logout_time);
							
							//UPDATING LOGIN
							$sql = "INSERT INTO U_logs (U_N,U_M,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE) VALUES ('$U_name','$IP','$date_login','$login_time','$logout_time','$date_logout')";
							$query_1 = mysqli_query($con,$sql);
							
							//LOGGING OTHER DEVICES OUT
							$sql = "UPDATE U_logged_in SET LOGGED_IN='N' WHERE U_N = '$U_name'";
							$query = mysqli_query($con,$sql);
														
							//UPDATING U_LI WITH CURRENT LOG OUT 
							$sql = "UPDATE U_videos SET U_LI = '0' WHERE U_M = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//UPDATING U_TP WITH CURRENT LOG OUT 
							$sql = "UPDATE U_videos SET U_TP = '0' WHERE U_M = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//GETTING LOGIN STATUS
							$sql = "SELECT LOGGED_IN FROM U_logged_in WHERE U_N = '$U_name'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							//VAR
							$code_3 = implode(" ",$row_1);
							
							// CHECKING "NEED TO PAY"
							$sql = "SELECT PAID FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							$code_4 = implode(" ",$row_1);
							$_SESSION['paid']=$code_4;
							
							// CHECKING CONNECTION FROM OTHER DEVICE
							if($code_3 == 'N')//NOT CONNECTED FROM OTHER DEVICE, NEEDS TO PAY
							{
								//UPDATING LOGIN
								$sql = "UPDATE U_logged_in SET LOGGED_IN = 'Y',LOGIN_DATE = '$date_login',LOGIN_TIME = '$login_time',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time',CODE = '$code_2', U_M='$IP', LOGGED_OUT='N',LOGOUT_IP='N' WHERE U_N = '$U_name'";
								$query_2 = mysqli_query($con,$sql);
								
								//UPDATING U_LI WITH CURRENT LOG IN 
								$sql = "UPDATE U_videos SET U_LI = '1',LOGOUT_TIME = '$logout_time' WHERE U_M = '$U_name'";
								$query_2 = mysqli_query($con,$sql);
								
								//UPDATING U_TP WITH CURRENT LOG IN 
								$sql = "UPDATE U_videos SET U_TP = '0' WHERE U_M = '$U_name'";
								$query_2 = mysqli_query($con,$sql);
								
								//PREPARING UNTIL WHEN SUBSCRIPTION IS VALID
								date_default_timezone_set('Asia/Jerusalem');
								$logout_time = time()+(3600);//1 hour later
								$date_logout = date('m/d/Y h:i:s a', $logout_time);
								
								$pn='מנוי לתמיד';
								
								//UPDATING USED CONFIRMATION NUMBER
								$m=$_SESSION['payed_4_e_mail'];
								$sql = "UPDATE U_videos SET PAID = 'Y',NUMBER = '$Num',PAID_TIME='$login_time', PRODUCT='$pn', VALID_UNTIL_DATE='$date_logout', VALID_UNTIL_TIME='$logout_time' WHERE U_M = '$U_name'";
								$query = mysqli_query($con,$sql);
								
								//CLOSING CONNECTION
								mysqli_close($con);
								
								//UPDATE USED NUMBER
								used_num($Num,$U_name,$U_name,$ip_address,$course_number_);
								
								//ATTRIBUTES//OUTPUT 
								$f = "registration@explainit.online";
								$f_1="Explainit Online - קורס ".$course_number_." - P03";
										
								//HEADERS
								$headers = "From: registration@explainit.online\r\n";
								$headers .= "Reply-To:registration@explainit.online\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=utf-8\r\n";
								
								//MESSAGE
								$message = '<html lang="iw" dir="rtl"><body>';
								$message .= '<div style="width:100%;margin:auto;text-align:center;">';
								$message .= '<h4>P03 - שימוש במספר אישור</h4>';
								$message .= '<h4>מייל:</h4>';
								$message .= '<h4>'.$U_name.'</h4>';
								$message .= '<h4>מספר אישור:</h4>';
								$message .= '<h4>'.$Num.'</h4>';
								$message .= '<h4>IP:</h4>';
								$message .= '<h4>'.$ip_address.'</h4>';
								$message .= "</div>";
								$message .= "</body></html>";
								
								//SENDING
								mail($f,$f_1,$message,$headers);
								
								//PAID
								$_SESSION['paid'] = 'Y';
								
								//SENT TO WLBACK_VIDEOS//OUTPUT 03
								header ("location: ../php/wl_fi/wlback_videos.php");
							}//NOT CONNECTED FROM OTHER DEVICE
							
							//CONNECTED FROM ANOTHER DEVICE
							else
							{
								//SESSION VARS
								$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>את/ה מחובר/ת ממכשיר אחר</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף ניתוק מכשיר אחר. לאחר מכן לחצ/י על הקישור של דף אישור תשלום בהתחברות.</h2></div>";
								$_SESSION['count']++;
								
								//SHOWING MESSAGE
								echo $_SESSION['message_1'];
								
								//SLEEPING
								sleep(2);
								
								//REDIRECTED TO DISCONNECT OTHER DEVICE//OUTPUT 04
								header ('location: ../php/error_fi/error_videos_2.php');
							}
							
							//DEBUGGING
							/*
							echo '<pre>';
							var_dump($_SESSION);
							echo '<br>';
							//var_dump($query_2);
							echo '</pre>';
							*/
						
						}//LOGIN SUCCESSFUL
						
						//LOGIN FAILED, WRONG PASSWORD
						else
						{
							//SESSION VARS
							$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>סיסמה לא נכונה</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף אישור תשלום שם תוכל/י לנסות שוב</h2></div>";
							$_SESSION['count']++;
							
							//SHOWING MESSAGE
							echo $_SESSION['message_1'];
							
							//ATTRIBUTES//OUTPUT 
								$f = "registration@explainit.online";
								$f_1="".$course_number_." - P03";
										
								//HEADERS
								$headers = "From: registration@explainit.online\r\n";
								$headers .= "Reply-To:registration@explainit.online\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=utf-8\r\n";
								
								//MESSAGE
								$message = '<html lang="iw" dir="rtl"><body>';
								$message .= '<div style="width:100%;margin:auto;text-align:center;">';
								$message .= '<h4>סיסמה לא נכונה</h4>';
								$message .= '<h4>מייל:</h4>';
								$message .= '<h4>'.$U_name.'</h4>';
								$message .= '<h4>מספר אישור:</h4>';
								$message .= '<h4>'.$Num.'</h4>';
								$message .= '<h4>IP:</h4>';
								$message .= '<h4>'.$_SERVER['REMOTE_ADDR'].'</h4>';
								$message .= "</div>";
								$message .= "</body></html>";
								
								//SENDING
								mail($f,$f_1,$message,$headers);
							
							//REDIRECTED TO CONFIRMATION STAND ALONE POST//OUTPUT 05
							echo '<script>setTimeout(function(){$("#d").click();}, 3000);</script>';
							echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
							
							//SLEEPING
							sleep(2);
							
						}//LOGIN FAILED	
					}//USER ACTIVATED ACCOUNT
					
					//USER HASN'T ACTIVATED ACCOUNT
					else
					{
						//SESSION VAR
						$_SESSION['v_wait'] = 1;
						
						//E-MAIL ACTIVATION PAGE//OUTPUT 06
						header ('location: ../php/v_fi/v_videos.php');
					}
				}//MAIL IS FOUND IN USERS' LIST
				
				//MAIL ISN'T FOUND IN USERS' LIST
				else
				{
					if(isset($U_name)&&$U_name!='')
					{
						//SESSION VARS
						$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>אין מייל כזה</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף אישור תשלום שם תוכל/י לנסות שוב.</h2></div>";
						$_SESSION['count']++;
						
						//SHOWING MESSAGE
						echo $_SESSION['message_1'];
						
						//ATTRIBUTES//OUTPUT 
						$f = "registration@explainit.online";
						$f_1="".$course_number_." - P03";
								
						//HEADERS
						$headers = "From: registration@explainit.online\r\n";
						$headers .= "Reply-To:registration@explainit.online\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						//MESSAGE
						$message = '<html lang="iw" dir="rtl"><body>';
						$message .= '<div style="width:100%;margin:auto;text-align:center;">';
						$message .= '<h4>P03 - מייל לא נמצא ברשימת לוגין</h4>';
						$message .= '<h4>מייל:</h4>';
						$message .= '<h4>'.$U_name.'</h4>';
						$message .= '<h4>מספר אישור:</h4>';
						$message .= '<h4>'.$Num.'</h4>';
						$message .= '<h4>IP:</h4>';
						$message .= '<h4>'.$_SERVER['REMOTE_ADDR'].'</h4>';
						$message .= "</div>";
						$message .= "</body></html>";
						
						//SENDING
						mail($f,$f_1,$message,$headers);
											
						//REDIRECTED TO CONFIRMATION STAND ALONE POST//OUTPUT 07
						echo '<script>setTimeout(function(){$("#d").click();}, 3000);</script>';
						echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
						
						//SLEEPING
						sleep(2);
					}//USER INSERTED MAIL
					
					//USER HASN'T INSERTED MAIL
					else
					{
						//SESSION VARS
						$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>לא הכנסת מייל</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף אישור תשלום שם תוכל/י לנסות שוב.</h2></div>";
						$_SESSION['count']++;
						
						//SHOWING MESSAGE
						echo $_SESSION['message_1'];
						
						//ATTRIBUTES//OUTPUT 
						$f = "registration@explainit.online";
						$f_1="".$course_number_." - P03";
								
						//HEADERS
						$headers = "From: registration@explainit.online\r\n";
						$headers .= "Reply-To:registration@explainit.online\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						//MESSAGE
						$message = '<html lang="iw" dir="rtl"><body>';
						$message .= '<div style="width:100%;margin:auto;text-align:center;">';
						$message .= '<h4>P03 - מייל לא נמצא ברשימת לוגין</h4>';
						$message .= '<h4>מייל:</h4>';
						$message .= '<h4>'.$U_name.'</h4>';
						$message .= '<h4>מספר אישור:</h4>';
						$message .= '<h4>'.$Num.'</h4>';
						$message .= '<h4>IP:</h4>';
						$message .= '<h4>'.$_SERVER['REMOTE_ADDR'].'</h4>';
						$message .= "</div>";
						$message .= "</body></html>";
						
						//SENDING
						mail($f,$f_1,$message,$headers);
												
						//REDIRECTED TO CONFIRMATION STAND ALONE POST//OUTPUT 08
						echo '<script>setTimeout(function(){$("#d").click();}, 3000);</script>';
						echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
						
						//SLEEPING
						sleep(2);
					}//USER HASN'T INSERTED MAIL
				}//MAIL ISN'T FOUND IN USERS' LIST
			}//PASSWORD IS LONG ENOUGH
			
			//PASSWORD ISN'T LONG ENOUGH
			else
			{
				//SESSION VARS
				$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>סיסמה לא נכונה</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף אישור תשלום שם תוכל/י לנסות שוב.</h2></div>";
				$_SESSION['count']++;
				
				//SHOWING MESSAGE
				echo $_SESSION['message_1'];
				
				//REDIRECTED TO CONFIRMATION STAND ALONE POST//OUTPUT 09
				echo '<script>setTimeout(function(){$("#d").click();}, 3000);</script>';
				echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
				
				//SLEEPING
				sleep(2);
			}//PASSWORD ISN'T LONG ENOUGH
		}//MAIL HAS NOT BEEN PAID FOR AND CONFIRMATION NUMBER VALID
		
		//MAIL OR CONFIRMATION CODE AREN'T VALID
		else
		{
			//SESSION VARS
			$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>מספר אישור תשלום לא נכון</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף אישור תשלום שם תוכל/י לנסות שוב.</h2></div>";
			$_SESSION['count']++;
			
			//ATTRIBUTES//OUTPUT 11
			$f = "registration@explainit.online";
			$f_1="Explainit Online - קורס ".$course_number_." - בעיית תשלום";
					
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>CONFIRMATION CODE NOT VALID</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$U_name.'</h4>';
			$message .= '<h4>IP:</h4>';
			$message .= '<h4>'.$ip_address.'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
		
			//SHOWING MESSAGE
			echo $_SESSION['message_1'];
			
			//REDIRECTED TO CONFIRMATION STAND ALONE POST//OUTPUT 10
				echo '<script>setTimeout(function(){$("#d").click();}, 3000);</script>';
				echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
			
			//SLEEPING
			sleep(2);
		}//MAIL OR CONFIRMATION NUMBER AREN'T VALID
	}//CHECKING COUNT < 4
	
	//COUNT USER TRIED CONFIRMING NUMBER TOO MANY TIMES
	else
	{
		//SESSION VAR
		$_SESSION['count'] = 0;
		
		//ATTRIBUTES//OUTPUT 11
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס ".$course_number_." - P03";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
		$message .= '<h4>ניסיון תשלום של יותר מ-4 פעמים</h4>';
		$message .= '<h4>מייל:</h4>';
		$message .= '<h4>'.$U_name.'</h4>';
		$message .= '<h4>IP:</h4>';
		$message .= '<h4>'.$ip_address.'</h4>';
		$message .= "</div>";
		$message .= "</body></html>";
		
		//SENDING
		mail($f,$f_1,$message,$headers);
		
		//ERROR 8 PAGE//OUTPUT 12
		header ('location: ../php/error_fi/error_videos_8.php');
	}//COUNT USER TRIED CONFIRMING NUMBER TOO MANY TIMES
}//POST REQUEST

?>

<head>
<!-- ENCODING -->
	<meta charset="utf-8">
		
	<!-- FAVICON --><!-- OUTPUT 01 UNMARKED -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 02 UNMARKED -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 03 UNMARKED -->
	<link rel="stylesheet" href="../css/2.css">
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
			
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<style>
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
</style>
</head>

<body>
	<div id="c" style="display:none;">	
	</div>
</body>
<script>
$("#d").click(function(){
	$("#c").toggle();
});

//OUTPUTS 05,07,08,09,10
$("#c").click(function(){
	window.location.replace("example_cleveland_l_videos_4_multi.php");
});
</script>