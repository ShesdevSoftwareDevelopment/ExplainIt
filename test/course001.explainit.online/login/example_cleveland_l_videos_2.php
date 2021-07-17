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
	$_SESSION['message_1']='הי,<br> כאן מנתקים התחברות ממכשיר אחר';
	if(!isset($_SESSION['count']))
	{	
		$_SESSION['count'] = 1;
	}
	
//FUNCTIONS
	//CHECKING LENGTH
	function valid($check)
	{
		//CHECKING LENGTH
		if (mb_strlen($check)>=8)
		{
			return TRUE;
		}	
	}
	
	//CHECKING LENGTH//? NEEDED
	function check_length($str)
	{
		//checking length
		if (mb_strlen($str)>=8)
		{
			return TRUE;
		}	
	}

//POST METHOD
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//DATABASE//CONNECTING//DATA
		$host = 'localhost';
		$username = 'elad189g_xo_course001';
		$password = 'Wonderfull5600';
		$db = 'elad189g_xo_course001_us';
		
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
		mysqli_select_db($con, "elad189g_xo_course001_us"); 
		
		//ENABLING HEBREW
		mysqli_query($con,"SET character_set_client=utf8mb4");
		mysqli_query($con,"SET character_set_connection=utf8mb4");
		mysqli_query($con,"SET character_set_database=utf8mb4");
		mysqli_query($con,"SET character_set_results=utf8mb4");
		mysqli_query($con,"SET character_set_server=utf8mb4");
		
		//SETTING TIME	
		$sql_Time = "SET time_zone = '+03:00';";
		$query = mysqli_query($con,$sql_Time);
	
	//WE'RE CONNECTED, SANITIZING POST DATA
	$U_name = $con->real_escape_string($_POST['user_name']);
	$P_ass = md5($con->real_escape_string($_POST['pass_word']));
	$_SESSION['u_n']=$U_name;//MAIL
	$ip_address=$_SERVER['REMOTE_ADDR'];//IP ADDRESS
	
	//DEBUGGING
	/*	echo '<pre>';
		echo $U_name;
		echo '<br>';
		echo $P_ass;
		echo '</pre>';
	*/	
	//REPORT MAIL//OUTPUT 00
		$e = "registration@explainit.online";		
		$f="registration@explainit.online";
		$f_1="התראת ניתוק חשבון";
		$f_2="".$U_name." מנסה לנתק חשבון אחר עם IP:".$ip_address."";
		mail($f,$f_1,$f_2,"FROM:".$e);
	
	//CHECKING COUNT
	if($_SESSION['count']<4)
	{
		//PASSWORD LONG ENOUGH
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
			
			//USER MAIL FOUND IN LIST
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
					
					//PASSWORD CORRECT
					if(mysqli_num_rows($query) > 0)
					{
						$sql = "SELECT U_N FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
						
						//SESSION VARS
						$_SESSION['u_n'] = implode(" ",$row);//IP ADDRESS
						$_SESSION['u_name']=$U_name;//MAIL
						$_SESSION['message_1'] = "התנתקות מוצלחת,";
						$_SESSION['loggedin'] = 1;
						
						//DEBUGGING
						/*
						echo '<pre>';
						var_dump($row);
						echo '<br>';
						//echo $P_ass;
						echo '</pre>';
						*/
						
						//SELECTING TIMESTAMP//? NEEDED
						$sql = "SELECT U_T1 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						
						//SESSION VAR
						$_SESSION['timestamp'] = implode(" ",$row_1);
						$code_1=$_SESSION['timestamp'];
						
						//SELECTING HASHED USER CODE//? NEEDED
						$sql = "SELECT CODE FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						
						//VAR
						$code_2 = implode(" ",$row_1);
												
						//SELECTING SIGNUP DATE//? NEEDED
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
						
						//UPDATING LOGS
						//LOGIN TIME
						date_default_timezone_set('Asia/Jerusalem');
						$login_time = time();
						$date_login = date('m/d/Y h:i:s a', time());
												
						//LOGOUT TIME
						date_default_timezone_set('Asia/Jerusalem');
						$logout_time = time()+(3600);//1 HOUT LATER
						$date_logout = date('m/d/Y h:i:s a', $logout_time);
						
						//UPDATING U_LOGS
						$sql = "INSERT INTO U_logs (U_N,U_M,LOGOUT_TIME,LOGOUT_DATE) VALUES ('$U_name','$IP','$logout_time','$date_logout')";
						$query_1 = mysqli_query($con,$sql);
						
						//GETTING LOGGED IN STATUS
						$sql = "SELECT LOGGED_IN FROM U_logged_in WHERE U_N = '$U_name'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						
						//LOGGED IN STATUS (Y OR N)
						$code_3 = implode(" ",$row_1);
						
						//OTHER DEVICE IS LOGGED IN
						if($code_3 == 'Y')
						{
							$sql = "UPDATE U_logged_in SET LOGGED_IN = 'N',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time',CODE = '$code_2', U_M='$IP', LOGGED_OUT='Y',LOGOUT_IP='N' WHERE U_N = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//DISCONNECTION OF OTHER DEVICE SUCCESSFUL, REDIRECTING TO WELCOME PAGE AFTER DISCONNECTION//OUTPUT 01
							header ("location: ../php/wl_fi/wlback_videos_2.php");
						}//OTHER DEVICE IS LOGGED IN
						
						//NO OTHER DEVICE IS LOGGED IN
						else
						{
							//DISCONNECTION OF OTHER DEVICE NOT NEEDED, REDIRECTING TO WELCOME PAGE AFTER DISCONNECTION//OUTPUT 02
							header ('location: ../php/wl_fi/wlback_videos_2.php');
						}//NO OTHER DEVICE IS LOGGED IN
						
							//DEBUGGING
							/*
							echo '<pre>';
							var_dump($_SESSION);
							echo '<br>';
							//var_dump($query_2);
							echo '</pre>';
							*/
					
					}//PASSWORD CORRECT
					
					//PASSWORD INCORRECT
					else
					{
						//SESSION VAR
						$_SESSION['message_1']="סיסמה לא נכונה";
						$_SESSION['count']++;
						
						//SLEEPING
						sleep(2);
					}//PASSWORD INCORRECT	
				}//ACCOUNT ACTIVATED
				
				//ACCOUNT HASN'T BEEN ACTIVATED
				else
				{
					//SESSION VAR
					$_SESSION['v_wait'] = 1;
					
					//E-MAIL AUTHENTICATION PAGE//OUTPUT 03
					header ('location: ../php/v_fi/v_videos.php');
				}//ACCOUNT HASN'T BEEN ACTIVATED
			}//USER MAIL FOUND IN LIST
			
			//USER MAIL NOT FOUND IN LIST
			else
			{
				//USER FILLED IN MAIL
				if(isset($U_name)&&$U_name!='')
				{
					$_SESSION['message_1']="אין מייל כזה<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
					$_SESSION['count']++;
					sleep(2);
				}//USER FILLED IN MAIL
				
				//USER DIDN'T FILL IN MAIL
				else
				{
					//SESSION VAR
					$_SESSION['message_1']="לא הכנסת מייל<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
					$_SESSION['count']++;
					
					//SLEEPING
					sleep(2);
				}//USER DIDN'T FILL IN MAIL
			}//USER MAIL NOT FOUND IN LIST
		}//PASSWORD LONG ENOUGH
		
		//PASSWORD NOT LONG ENOUGH
		else
		{
			//SESSION VAR
			$_SESSION['message_1']="סיסמה לא נכונה<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
			$_SESSION['count']++;
			
			//SLEEPING
			sleep(2);
		}//PASSWORD NOT LONG ENOUGH
	}//COUNT < 4
	
	//COUNT > 4
	else
	{
		//SESSION VAR
		$_SESSION['count'] = 0;
		
		//REPORT MAIL//OUTPUT 04
		$e = "registration@explainit.online";		
		$f="registration@explainit.online";
		$f_1="התראה מדף ERROR 2";
		$f_2="".$U_name." ניסה/תה להתחבר יותר מ-4 פעמים. IP:".$ip_address."";
		mail($f,$f_1,$f_2,"FROM:".$e);
		
		//ERROR 3 PAGE//OUTPUT 05
		header ('location: ../php/error_fi/error_videos_3.php');
	}//COUNT > 4
}//POST METHOD

?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 06 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
		
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 07 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 08 -->
	<link rel="stylesheet" href="../css/2.css">
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>

<body>
<!-- CONTENT DIV -->
<div style="direction:rtl;text-align:center;">
	<!-- TEXT -->
	<h1 style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	
	<!-- EMOJI -->
	<i class="em em-writing_hand"></i>
		
	<!-- DISCONNECTION FORM --><!-- OUTPUT 09 -->
	<form action="example_cleveland_l_videos_2.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מייל" name="user_name" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" required><br>
		<div style="font-size:14px;"><!-- FORGOT PASSWORD --><!-- OUTPUT 10 --><a href="f_videos.php">שכחתי סיסמה</a></div>
		
		<!-- EMOJI -->
		<div>
			<i id="p" class="em em-airplane"></i>
		</div>
		
		<!-- SUBMIT -->
		<div style="width:50%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="ניתוק מכשיר אחר" name="register">
		</div>
		
	</form><!-- DISCONNECTION FORM -->
</div><!-- CONTENT DIV -->

</body>