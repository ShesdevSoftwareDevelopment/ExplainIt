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

//VARS
$course_number="006";

//SESSION VARS	
	$U_name = '';
	$_SESSION['loggedin'] = 0;
	
	if(!isset($_SESSION['count']))
	{	
		$_SESSION['count'] = 1;
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
	//? NEEDED
	function check_length($str)
	{
		//CHECKING LENGTH
		if (mb_strlen($str)>=8)
		{
			return TRUE;
		}	
	}
	
	//CONNECT TO DB TO SEE IF NUMBER EXISTS.
	//- GETS CONFIRMATION NUMBER AND MAIL.
	//- CHECKS IF MAIL HAS BEEN PAID FOR.
	//- CHECKS IF CONFIRMATION NUMBER HAS BEEN USED.
	//RETURNS 1 IF CONFIRMATION IS SUCCESSFUL, 2 IF CONFIRMATION FAILED.
	function check_num($n,$mail,$U_name,$ip_address,$course_number)
	{
		//DATABASE//CONNECTING TO PAYMENTS//DATA
		//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
		//*include "../php/test_fi/test_po_7.php";
			
		//GET DB DETAILS
			$new_path = 'test_02';
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
			//echo 'connection ok';
		}
		else
		{
			die('Could not connect: '.mysqli_error($con));
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

		//WE'RE CONNECTED//QUERIES//CHECKING IF THIS MAIL HAS BEEN PAID FOR
		$sql = "SELECT ID FROM Pay_today_POST_MULTI WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		//THIS MAIL ALREADY HAS BEEN PAID FOR
		if (mysqli_num_rows($query) > 0)
		{
			//ERROR 8 PAGE//OUTPUT 00
			header ('location: ../php/error_fi/error_videos_8.php');
		}//THIS MAIL ALREADY HAS BEEN PAID FOR
		
		//QUERY CONFIRMATION CODE
		$sql = "SELECT email FROM Pay_today_POST_MULTI WHERE ConfirmationCode = '$n' AND USED = 'N'";
		$query = mysqli_query($con,$sql);
		
		//CONFIRMATION NUMBER FOUND
		if (mysqli_num_rows($query) > 0)
		{	
			//CHECKING IF PAYMENT NUMBER HASN'T ALREADY BEEN USED
			$sql = "SELECT email FROM Pay_today_POST_MULTI WHERE ConfirmationCode = '$n' AND USED = 'Y'";
			$query = mysqli_query($con,$sql);
			
			if(mysqli_num_rows($query) > 0)// CONFIRMATION NUMBER ALREADY HAS BEEN USED			
			{	
				//ATTRIBUTES//OUTPUT 11
				$f = "registration@explainit.online";
				$f_1="Explainit Online - קורס ".$course_number." - השתמשו במספר אישור הזה מדף אישור תשלום";
						
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
						 
				return(2);
			}
			
			else
			{	
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
		}//CONFIRMATION NUMBER FOUND
		
		//CONFIRMATION NUMBER WASN'T FOUND - CONTACT BY PHONE
		else
		{
			//CONFIRMATION NUMBER ISN'T VALID
			return(2);
		}//CONFIRMATION NUMBER WASN'T FOUND - CONTACT BY PHONE
	}//function check_num($n,$mail)
	
	//CONNECTS TO DB TO SEE IF NUMBER EXISTS
	//- GETS MAIL AND CONFIRMATION NUMBER.
	//- CHECKS IF MAIL HAS BEEN PAID FOR.
	//- IF NOT, UPDATES MAIL WITH THE CONFIRMATION NUMBER.
	//RETURNS NOTHING.
	function used_num($n,$mail)
	{
		//DATABASE//CONNECTING TO PAYMENTS//DATA
		//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
		//*include "../php/test_fi/test_po_7.php";
	
		//GET DB DETAILS
			$new_path = 'test_02';
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
			//echo 'connection ok';
		}
		else
		{
			die('Could not connect: '.mysqli_error($con));
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

		//WE'RE CONNECTED//QUERIES//CHECKING IF THIS MAIL HAS BEEN PAID FOR
		$sql = "SELECT ID FROM Pay_today_POST_MULTI WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		//THIS MAIL ALREADY HAS BEEN PAID FOR
		if (mysqli_num_rows($query) > 0)
		{
			//ERROR 8 PAGE//OUTPUT 01
			header ('location: ../php/error_fi/error_videos_8.php');
		}//THIS MAIL ALREADY HAS BEEN PAID FOR
		
		//THIS MAIL HASN'T BEEN PAID FOR
		else
		{
			//UPDATING USED CONFIRMATION NUMBER
			$sql = "UPDATE Pay_today_POST_MULTI SET USED = 'Y',BY_MAIL='$mail' WHERE ConfirmationCode = '$n'";
			$query = mysqli_query($con,$sql);
		}//THIS MAIL HASN'T BEEN PAID FOR
		
		//CLOSING CONNECTION
		mysqli_close($con);
	}//function used_num($n,$mail)
	
//SESSION VARS
	$_SESSION['message_1']='אישור תשלום';

//POST REQUEST
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
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
	
	//SANITIZING DATA
	$U_name = $con->real_escape_string($_POST['user_name']);
	$P_ass = md5($con->real_escape_string($_POST['pass_word']));
	$Num = $con->real_escape_string($_POST['payment_no']);
		
	//VARS//? NEEDED
	$_SESSION['u_n']=$U_name;
	$ip_address=$_SERVER['REMOTE_ADDR'];
		
	//CHECKING COUNT
	if($_SESSION['count']<2)
	{
		//CHECKING IF MAIL AND CONFIRMATION NUMBER ARE VALID
		$v=check_num($Num,$U_name,$U_name,$ip_address,$course_number);
		
		//FOUND CONFIRMATION CODE AND STORED E_MAIL IN SESSION VAR
		if($v == 1)
		{
			//CHECKING PASSWORD LENGTH
			if(check_length($P_ass))
			{
				//PASSWORD LONG ENOUGH, RETRIEVING
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
				
				//MAIL EXISTS IN LIST
				if (mysqli_num_rows($query) > 0)
				{	
					//ACCOUNT ACTIVATED
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
							//LOGIN SUCCESSFUL
							$sql = "SELECT U_N FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							//SESSION VARS//? NEEDED
							$_SESSION['u_n'] = implode(" ",$row);
							$_SESSION['u_name']=$U_name;
							$_SESSION['message_1'] = "התחברות מוצלחת,";
							$_SESSION['loggedin'] = 1;
							
							//DEBUGGING
							/*
							echo '<pre>';
							var_dump($row);
							echo '<br>';
							//echo $P_ass;
							echo '</pre>';
							*/
							
							//GETTING TIMESTAMP//? NEEDED							
							$sql = "SELECT U_T1 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							//SESSION VAR
							$_SESSION['timestamp'] = implode(" ",$row_1);
							$code_1=$_SESSION['timestamp'];
							
							//GETTING HASHED USER CODE//? NEEDED
							$sql = "SELECT CODE FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							$code_2 = implode(" ",$row_1);
							
							//GETTING SIGNUP DATE//? NEEDED							
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
							
							//PREPARING DIRECTORY NAME//? NEEDED
							$_SESSION['dir_01'] = implode(" ",$row_2);
							$_SESSION['directory'] = $_SESSION['dir_01']."-".$_SESSION['timestamp'];
							$directory = $_SESSION['dir_01']."-".$_SESSION['timestamp'];
							$IP=$_SERVER['REMOTE_ADDR'];
							
							//UPDATING LOGS//LOGIN TIME
							date_default_timezone_set('Asia/Jerusalem');
							$login_time = time();
							$date_login = date('m/d/Y h:i:s a', time());
													
							//LOGOUT TIME
							date_default_timezone_set('Asia/Jerusalem');
							$logout_time = time()+(3600);//1 hour later
							$date_logout = date('m/d/Y h:i:s a', $logout_time);
							
							//UPDATING LOGIN
							$sql = "INSERT INTO U_logs (U_N,U_M,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE,PAGE) VALUES ('$U_name','$IP','$date_login','$login_time','$logout_time','$date_logout','L_04')";
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
								
							//CHECKING CONNECTION FROM OTHER DEVICES
							if($code_3 == 'N')//NOT CONNECTED FROM OTHER DEVICE
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
								
								//UPDATING USED CONFIRMATION NUMBER
								$m=$_SESSION['payed_4_e_mail'];
								$sql = "UPDATE U_videos SET PAID = 'Y',NUMBER = '$Num' WHERE U_M = '$U_name'";
								$query = mysqli_query($con,$sql);
								
								//CLOSING CONNECTION
								mysqli_close($con);
								
								//UPDATE USED NUMBER
								used_num($Num,$m);
								
								//ATTRIBUTES//OUTPUT 02
								$f = "registration@explainit.online";
								$f_1="Explainit Online - קורס ".$course_number." - P04 - שימוש במספר אישור";
										
								//HEADERS
								$headers = "From: registration@explainit.online\r\n";
								$headers .= "Reply-To:registration@explainit.online\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=utf-8\r\n";
								
								//MESSAGE
								$message = '<html lang="iw" dir="rtl"><body>';
								$message .= '<div style="width:100%;margin:auto;text-align:center;">';
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
							
							//CONNECTED FROM OTHER DEVICE
							else
							{
								//SESSION VARS
								$_SESSION['message_1']="את/ה מחובר/ת ממכשיר אחר<h4 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף ניתוק מכשיר אחר. לאחר מכן לחצ/י על הקישור של דף אישור תשלום בהתחברות.</h4>";
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
						
						//LOGIN WASN'T SUCCESSFUL
						else
						{
							$_SESSION['message_1']="סיסמה לא נכונה";
							$_SESSION['count']++;
							
							//ATTRIBUTES//OUTPUT
							$f = "registration@explainit.online";
							$f_1="Explainit Online - קורס ".$course_number." - P04 - סיסמה לא נכונה";
									
							//HEADERS
							$headers = "From: registration@explainit.online\r\n";
							$headers .= "Reply-To:registration@explainit.online\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=utf-8\r\n";
							
							//MESSAGE
							$message = '<html lang="iw" dir="rtl"><body>';
							$message .= '<div style="width:100%;margin:auto;text-align:center;">';
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
							
							sleep(2);
						}//LOGIN WASN'T SUCCESSFUL	
					}//ACCOUNT ACTIVATED
					
					//ACCOUNT HASN'T BEEN ACTIVATED
					else
					{
						//SESSION VAR
						$_SESSION['v_wait'] = 1;
						
						//ACCOUNT CONFIRMATION PAGE//OUTPUT 05
						header ('location: ../php/v_fi/v_videos.php');
					}//ACCOUNT HASN'T BEEN ACTIVATED
				}//MAIL EXISTS IN LIST
				
				//MAIL DOESN'T EXIST IN LIST
				else
				{
					//USER INSERTED MAIL
					if(isset($U_name)&&$U_name!='')
					{
						$_SESSION['message_1']="אין מייל כזה<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב או לחץ למטה להרשמה</h4>";
						
						$_SESSION['count']++;
						
						//ATTRIBUTES//OUTPUT
						$f = "registration@explainit.online";
						$f_1="Explainit Online - קורס ".$course_number." - P04 - אין מייל כזה";
								
						//HEADERS
						$headers = "From: registration@explainit.online\r\n";
						$headers .= "Reply-To:registration@explainit.online\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						//MESSAGE
						$message = '<html lang="iw" dir="rtl"><body>';
						$message .= '<div style="width:100%;margin:auto;text-align:center;">';
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
						
						echo '<script>setTimeout(function(){document.getElementById("c").click();}, 3000);</script>';
						
						sleep(2);
					}//USER INSERTED MAIL
					
					//USER HASN'T INSERTED MAIL
					else
					{
						$_SESSION['message_1']="לא הכנסת מייל<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
						$_SESSION['count']++;
						sleep(2);
					}//USER HASN'T INSERTED MAIL
				}//MAIL DOESN'T EXIST IN LIST
			}//PASSWORD LONG ENOUGH
			
			//PASSWORD NOT LONG ENOUGH
			else
			{
				$_SESSION['message_1']="סיסמה לא נכונה<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
				$_SESSION['count']++;
				
				//ATTRIBUTES//OUTPUT
				$f = "registration@explainit.online";
				$f_1="Explainit Online - קורס ".$course_number." - P04 - סיסמה לא נכונה";
						
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;">';
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
				
				sleep(2);
			}//PASSWORD NOT LONG ENOUGH
		}//MAIL AND CONFIRMATION NUMBER VALID
		
		//MAIL AND CONFIRMATION NUMBER AREN'T VALID
		else
		{
			$_SESSION['message_1']="מספר אישור לא נכון<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
			$_SESSION['count']++;
			
			//ATTRIBUTES//OUTPUT
			$f = "registration@explainit.online";
			$f_1="Explainit Online - קורס ".$course_number." - P04 - שימוש במספר אישור לא נכון";
					
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
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
			
			//SLEEP
			sleep(2);
		}//MAIL AND CONFIRMATION NUMBER AREN'T VALID
	}//COUNT < 4
	
	//COUNT > 4
	else
	{
		$_SESSION['count'] = 0;
		
		//ATTRIBUTES//OUTPUT 06
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס ".$course_number." - P04 - ניסיון תשלום של יותר מ-4 פעמים";
				
		//HEADERS
		$headers = "From: registration@explainit.online\r\n";
		$headers .= "Reply-To:registration@explainit.online\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		
		//MESSAGE
		$message = '<html lang="iw" dir="rtl"><body>';
		$message .= '<div style="width:100%;margin:auto;text-align:center;">';
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
				
		//ERROR 8 PAGE//OUTPUT 07
		header ('location: ../php/error_fi/error_videos_8.php');
	}//COUNT > 4
}//POST REQUEST

?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- TITLE -->
	<title>פיזיקה לבגרות | מכניקה | אישור תשלום</title>
	
	<!-- DESCRIPTION -->
	<meta name="description" content='אישור תשלום'>
			
	<!-- FAVICON --><!-- OUTPUT 08 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 09 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 10 -->
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
		background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 11 */
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
<div style="direction:rtl;text-align:center;">
	<!-- TEXT -->
	<h1 id="c" style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<!-- TEXT -->
	<h4 style="margin-bottom:0px;">מלא/י את המייל והסיסמה איתם נרשמת לאתר, ואת מספר אישור התשלום שקיבלת במייל אחרי התשלום.</h4>
	
	<!-- EMOJI -->
	<i class="em em-writing_hand"></i>
		
	<!-- SELF POST --><!-- OUTPUT 12 -->
	<form action="example_cleveland_l_videos_4_multi.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מייל" name="user_name" autocomplete="mail" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מספר אישור תשלום" name="payment_no" required><br>
		<div style="font-size:14px;"><!-- FORGOT PASSWORD --><!-- OUTPUT 13 --><a href="f_videos.php">שכחתי סיסמה</a></div>
		
		<!-- EMOJI -->
		<div>
			<i id="p" class="em em-airplane"></i>
		</div>
		
		<!-- SUBMIT BUTTON -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="התחבר" name="register">
		</div>
	</form>
	
	<!-- SIGNUP DIV -->
	<div id="a_8" style="display:none;">
		
		<!-- HORIZONTAL LINE -->
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<!-- SIGNUP PAGE -->
		<h4 style="margin:0px 0px 5px 0px;">להרשמה:</h4>
		<!-- SIGNUP PAGE --><!-- OUTPUT 14 --><a href="example_cleveland.php">
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="הרשמה" name="register">
		</div>
		</a>
	</div>
</div>

<script>
$("#a_1").click(function(){
	$("#input_1").val('<?= $U_name ?>');
});

$("#c").click(function(){
	document.getElementById("a_8").style.display="block";
});
</script>
</body>