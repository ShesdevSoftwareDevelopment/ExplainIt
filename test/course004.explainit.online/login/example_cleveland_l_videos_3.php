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
	function check_num($n,$mail)
	{
		//DATABASE//CONNECTING TO PAYMENTS//DATA
		//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
		//*	include "../php/test_fi/test_po_7.php";
			
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

		//QUERIES//CHECKING IF THIS MAIL HAS BEEN PAID FOR
		$sql = "SELECT ID FROM Pay_today_POST WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		//THIS MAIL SHOWS UP IN THE PAID FOR MAILS LIST
		if (mysqli_num_rows($query) > 0)
		{
			//ERROR 8 PAGE//OUTPUT 00
			header ('location: ../php/error_fi/error_videos_8.php');
		}
		
		//THIS MAIL DOESN'T SHOW UP IN THE PAID FOR LIST AND IS VALID, CHECKING CONFIRMATION NUMBER.
		//QUERY//CONFIRMATION CODE
		$sql = "SELECT email FROM Pay_today_POST WHERE ConfirmationCode = '$n' AND USED = 'N'";
		$query = mysqli_query($con,$sql);
		
		//CONFIRMATION NUMBER FOUND// ADDITIONAL CHECKING NEEDED BECAUSE ON PREVIOUS PAGE REFRESH THE CONFIRMATION NUMBER IS SET TO 'N', EVEN IF IT HAS ALREADY BEEN USED.
		if (mysqli_num_rows($query) > 0)
		{	
			//CHECKING IF PAYMENT NUMBER HASN'T ALREADY BEEN USED
			$sql = "SELECT email FROM Pay_today_POST WHERE ConfirmationCode = '$n' AND USED = 'Y'";
			$query = mysqli_query($con,$sql);
			
			//CONFIRMATION NUMBER ALREADY HAS BEEN USED			
			if(mysqli_num_rows($query) > 0)
			{	
				//RETURNING 2//CONFIRMATION FAILED
				return(2);
			}//CONFIRMATION NUMBER ALREADY HAS BEEN USED
			
			//CONFIRMATION NUMBER HASN'T BEEN USED AND IS VALID
			else
			{	
				//SESSION VAR
				$_SESSION['payed_4_e_mail'] = $mail;
					
				//UPDATING USED CONFIRMATION NUMBER
				$sql = "UPDATE Pay_today_POST SET USED = 'Y' WHERE ConfirmationCode = '$n'";
				$query = mysqli_query($con,$sql);
				
				//CLOSING CONNECTION
				mysqli_close($con);
				
				//RETURNING 1//CONFIRMATION SUCCESSFUL
				return(1);
			}//CONFIRMATION NUMBER HASN'T BEEN USED
		}
		//CONFIRMATION NUMBER DOESN'T EXIST - CONTACT BY PHONE
		else
		{
			return(2);
		}//CONFIRMATION NUMBER DOESN'T EXIST - CONTACT BY PHONE
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
		//*	include "../php/test_fi/test_po_7.php";
			
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

		//WE'RE CONNECTED//QUERIE//CHECKING IF THIS MAIL HAS BEEN PAID FOR
		$sql = "SELECT ID FROM Pay_today_POST WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		//THIS MAIL ALREADY HAS BEEN PAID FOR
		if (mysqli_num_rows($query) > 0)
		{
			//ERROR PAGE 8//OUTPUT 01
			header ('location: ../php/error_fi/error_videos_8.php');
		}//THIS MAIL ALREADY HAS BEEN PAID FOR
		
		//USER HASN'T ALREADY PAID WITH THIS MAIL
		else
		{
			//UPDATING USED CONFIRMATION NUMBER
			$sql = "UPDATE Pay_today_POST SET USED = 'Y',BY_MAIL='$mail' WHERE ConfirmationCode = '$n'";
			$query = mysqli_query($con,$sql);
		}//USER HASN'T ALREADY PAID WITH THIS MAIL	
		
		//CLOSING CONNECTION
		mysqli_close($con);
	}//function used_num($n,$mail)

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
	
	//WE'RE CONNECTED, SANITIZING DATA
	$U_name = $con->real_escape_string($_POST['user_name']);
	$P_ass = md5($con->real_escape_string($_POST['pass_word']));
	$Num = $con->real_escape_string($_POST['payment_no']);
		
	//SESSION VARS
	$_SESSION['u_n']=$U_name;
	$ip_address=$_SERVER['REMOTE_ADDR'];
		
	//CHECKING COUNT < 4
	if($_SESSION['count']<4)
	{
		//COUNT OK, CHECKING IF MAIL HAS BEEN PAID FOR AND IF CONFIRMATION NUMBER HAS BEEN USED
		$v=check_num($Num,$U_name);
		
		if($v == 1)//CONFIRMATION CODE AND MAIL ARE VALID AND E_MAIL IS STORED IN SESSION VAR
		{
			//CHECKING PASSWORD
			if(check_length($P_ass))
			{
				//RETRIEVING
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
				
				//FOUND MAIL IN USERS' LIST
				if (mysqli_num_rows($query) > 0)
				{	
					//CHECKING ACTIVATION
					if($row['U_AP'] == 1)
					{
						//CHECKING PASSWORD
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
						
						//LOGIN SUCCESSFUL
						if(mysqli_num_rows($query) > 0)
						{
							//GETTING USER IP//? NEEDED
							$sql = "SELECT U_N FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
							$_SESSION['u_n'] = implode(" ",$row);
							
							//SESSION VARS//? NEEDED
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
							
							//GETTING HASHED USER CODE//? NEEDED
							$sql = "SELECT CODE FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							//VAR
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
							
							//UPDATING LOGS	//LOGIN TIME
							date_default_timezone_set('Asia/Jerusalem');
							$login_time = time();
							$date_login = date('m/d/Y h:i:s a', time());
													
							//LOGOUT TIME
							date_default_timezone_set('Asia/Jerusalem');
							$logout_time = time()+(3600);//1 hour later
							$date_logout = date('m/d/Y h:i:s a', $logout_time);
							
							//UPDATING LOGIN
							$sql = "INSERT INTO U_logs (U_N,U_M,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE,PAGE) VALUES ('$U_name','$IP','$date_login','$login_time','$logout_time','$date_logout','L_03')";
							$query_1 = mysqli_query($con,$sql);
							
							//LOGGING OTHER DEVICES OUT 
							$sql = "UPDATE U_logged_in SET LOGGED_IN='N' WHERE U_N = '$U_name'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
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
								
								//PREPARING UNTIL WHEN SUBSCRIPTION IS VALID
								date_default_timezone_set('Asia/Jerusalem');
								$logout_time = time()+(31536000);//1 YEAR LATER
								$date_logout = date('m/d/Y h:i:s a', $logout_time);
								
								$pn='מנוי שנתי';
								
								//UPDATING USED CONFIRMATION NUMBER
								$m=$_SESSION['payed_4_e_mail'];
								$sql = "UPDATE U_videos SET PAID = 'Y',NUMBER = '$Num',PAID_TIME='$login_time', PRODUCT='$pn', VALID_UNTIL_DATE='$date_logout', VALID_UNTIL_TIME='$logout_time' WHERE U_M = '$U_name'";
								$query = mysqli_query($con,$sql);
								
								//CLOSING CONNECTION
								mysqli_close($con);
								
								//UPDATE USED NUMBER
								used_num($Num,$m);
								
								//ATTRIBUTES//OUTPUT 
								$f = "registration@explainit.online";
								$f_1="Explainit Online - קורס 004 - P03 - שימוש במספר אישור";
										
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
								$f_1="004 - P03 - סיסמה לא נכונה";
										
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
		}//CONFIRMATION CODE AND MAIL ARE VALID
		
		//CONFIRMATION CODE AND MAIL AREN'T VALID
		else
		{
			//SESSION VARS
			$_SESSION['message_1']="<div style='width:100%;margin:auto;text-align:center;direction:rtl;'><h1>מספר אישור תשלום לא נכון</h1><h2 id='a_1' style='margin:2px auto;'>את/ה מועבר/ת לדף אישור תשלום שם תוכל/י לנסות שוב.</h2></div>";
			$_SESSION['count']++;
			
			//SHOWING MESSAGE
			echo $_SESSION['message_1'];
			
			//REDIRECTED TO CONFIRMATION STAND ALONE POST//OUTPUT 10
				echo '<script>setTimeout(function(){$("#d").click();}, 3000);</script>';
				echo '<script>setTimeout(function(){$("#c").click();}, 5000);</script>';
			
			//SLEEPING
			sleep(2);
					
		}//CONFIRMATION CODE AND MAIL AREN'T VALID
	}//CHECKING COUNT < 4
	
	//COUNT USER TRIED CONFIRMING NUMBER TOO MANY TIMES
	else
	{
		//SESSION VAR
		$_SESSION['count'] = 0;
		
		//ATTRIBUTES//OUTPUT 11
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס 004 - P03 - ניסיון תשלום של יותר מ-4 פעמים";
				
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
	window.location.replace("example_cleveland_l_videos_4.php");
});
</script>