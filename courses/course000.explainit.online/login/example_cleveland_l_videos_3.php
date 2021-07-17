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
// Vars	
	$U_name = '';
	$_SESSION['loggedin'] = 0;
	
	if(!isset($_SESSION['count']))
	{	
		$_SESSION['count'] = 1;
	}

// Functions
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
	function check_num($n,$mail)
	{
		//DATABASE
		//CONNECT TO DB TO SEE IF NUMBER EXISTS
		//CONNECTING TO PAYMENTS
		//DATA
		$host = 'localhost';
		$username = 'elad189g_xo_course001';
		$password = 'Wonderfull5610';
		$db = 'elad189g_xo_course001_payment';
		
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
		mysqli_select_db($con, "elad189g_ex_payment"); 
		
		// Enabling Hebrew
		mysqli_query($con,"SET character_set_client=utf8mb4");
		mysqli_query($con,"SET character_set_connection=utf8mb4");
		mysqli_query($con,"SET character_set_database=utf8mb4");
		mysqli_query($con,"SET character_set_results=utf8mb4");
		mysqli_query($con,"SET character_set_server=utf8mb4");
		
		// Setting Time	
		$sql_Time = "SET time_zone = '+03:00';";
		$query = mysqli_query($con,$sql_Time);

		// QUERIES	
		// CHECKING IF THIS MAIL HAS BEEN PAID FOR
		$sql = "SELECT ID FROM Pay_today_POST WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		if (mysqli_num_rows($query) > 0)// THIS MAIL ALREADY HAS BEEN PAID FOR
		{
			//OUTPUT
			header ('location: ../php/error_fi/error_videos_8.php');
		}
		
		// QUERY CONFIRMATION CODE
		$sql = "SELECT email FROM Pay_today_POST WHERE ConfirmationCode = '$n' AND USED = 'N'";
		$query = mysqli_query($con,$sql);
		
		//EXISTS
		if (mysqli_num_rows($query) > 0)// CONFIRMATION NUMBER FOUND
		{	
			//CHECKING IF PAYMENT NUMBER HASN'T ALREADY BEEN USED
			$sql = "SELECT email FROM Pay_today_POST WHERE ConfirmationCode = '$n' AND USED = 'Y'";
			$query = mysqli_query($con,$sql);
			
			if(mysqli_num_rows($query) > 0)// CONFIRMATION NUMBER ALREADY HAS BEEN USED			
			{	
				return(2);
			}
			
			else
			{	
				$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
				$_SESSION['payed_4_e_mail'] = implode(" ",$row);
							
				//UPDATING USED CONFIRMATION NUMBER
				$sql = "UPDATE Pay_today_POST SET USED = 'Y' WHERE ConfirmationCode = '$n'";
				$query = mysqli_query($con,$sql);
				
				//CLOSING CONNECTION
				mysqli_close($con);
						
				return(1);
			}
		}
		else//NOT EXIST - CONTACT BY PHONE
		{
			return(2);
		}
	}
	function used_num($n,$mail)
	{
		//DATABASE
		//CONNECT TO DB TO SEE IF NUMBER EXISTS
		//CONNECTING TO PAYMENTS
		//DATA
		$host = 'localhost';
		$username = 'elad189g_xo_course001';
		$password = 'Wonderfull5610';
		$db = 'elad189g_xo_course001_payment';
		
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
		mysqli_select_db($con, "elad189g_ex_payment"); 
		
		// Enabling Hebrew
		mysqli_query($con,"SET character_set_client=utf8mb4");
		mysqli_query($con,"SET character_set_connection=utf8mb4");
		mysqli_query($con,"SET character_set_database=utf8mb4");
		mysqli_query($con,"SET character_set_results=utf8mb4");
		mysqli_query($con,"SET character_set_server=utf8mb4");
		
		// Setting Time	
		$sql_Time = "SET time_zone = '+03:00';";
		$query = mysqli_query($con,$sql_Time);

		// QUERIES	
		// CHECKING IF THIS MAIL HAS BEEN PAID FOR
		$sql = "SELECT ID FROM Pay_today_POST WHERE BY_MAIL='$mail'";
		$query = mysqli_query($con,$sql);
		
		if (mysqli_num_rows($query) > 0)// THIS MAIL ALREADY HAS BEEN PAID FOR
		{
			//OUTPUT
			header ('location: ../php/error_fi/error_videos_8.php');
		}
		else// USER HASN'T ALREADY PAID WITH THIS MAIL
		{
			//UPDATING USED CONFIRMATION NUMBER
			$sql = "UPDATE Pay_today_POST SET USED = 'Y',BY_MAIL='$mail' WHERE ConfirmationCode = '$n'";
			$query = mysqli_query($con,$sql);
		}	
		//CLOSING CONNECTION
		mysqli_close($con);
	}
	
// Vars
	$_SESSION['message_1']='הי,<br> כאן מתחברים';

// Data
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//DATABASE
	// CONNECTING
	// DATA
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
		$v=check_num($Num);
		
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
							
							$sql = "INSERT INTO U_logs (U_N,U_M,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE) VALUES ('$U_name','$IP','$date_login','$login_time','$logout_time','$date_logout')";
							$query_1 = mysqli_query($con,$sql);
							
							$sql = "UPDATE U_logged_in SET LOGGED_IN='N' WHERE U_N = '$U_name'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
							$sql = "SELECT LOGGED_IN FROM U_logged_in WHERE U_N = '$U_name'";
							$query = mysqli_query($con,$sql);
							$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
							
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
								$sql = "UPDATE U_logged_in SET LOGGED_IN = 'Y',LOGIN_DATE = '$date_login',LOGIN_TIME = '$login_time',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time',CODE = '$code_2', U_M='$IP', LOGGED_OUT='N',LOGOUT_IP='N' WHERE U_N = '$U_name'";
								$query_2 = mysqli_query($con,$sql);
								
								//PREPARING UNTIL WHEN SUBSCRIPTION IS VALID
								date_default_timezone_set('Asia/Jerusalem');
								$logout_time = time()+(31536000);//1 YEAR later
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
								
								//MAIL
								//REPORT MAIL
								$e = "registration@explainit.online";		
								$f="registration@explainit.online";
								$f_1="".$m." השתמש במספר אישור";
								$f_2="כתובת: ".$ip_address." מס' אישור: ".$Num;
								mail($f,$f_1,$f_2,"FROM:".$e);
								
								//PAID
								$_SESSION['paid'] = 'Y';
								
								//OUTPUT
								//SENT TO WLBACK_VIDEOS
								header ("location: ../php/wl_fi/wlback_videos.php");
							}
							else
							{
								//OUTPUT
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
						
						}
						else
						{
							$_SESSION['message_1']="סיסמה לא נכונה";
							$_SESSION['count']++;
							sleep(2);
						}	
					}
					else
					{
						$_SESSION['v_wait'] = 1;
						
						//OUTPUT
						header ('location: ../php/v_fi/v_videos.php');
					}
				}//activation
				else
				{
					if(isset($U_name)&&$U_name!='')
					{
						$_SESSION['message_1']="אין מייל כזה<h4 id='a_1' style='margin:2px auto;'>נסה שוב או לחץ למטה להרשמה</h4>";
						$_SESSION['count']++;
						echo '<script>setTimeout(function(){$("#c").click();}, 1000);</script>';
						sleep(2);
					}
					else
					{
						$_SESSION['message_1']="לא הכנסת מייל<h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
						$_SESSION['count']++;
						sleep(2);
					}
				}
			}
			else
			{
				$_SESSION['message_1']="סיסמה לא נכונה<h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
				$_SESSION['count']++;
				sleep(2);
			}
		}
		else
		{
			$_SESSION['message_1']="מספר אישור לא נכון<h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
			$_SESSION['count']++;
			sleep(2);
		}
	}
	else
	{
		$_SESSION['count'] = 0;
		
		//MAIL
		//report mail
		$e = "registration@explainit.online";		
		$f="registration@explainit.online";
		$f_1="ל-".$U_name." יש בעיות עם החשבון";
		$f_2=$ip_address;
		mail($f,$f_1,$f_2,"FROM:".$e);
		
		//OUTPUT
		header ('location: ../php/error_fi/error_videos_8.php');
	}
}

?>
