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
	
// Vars
	$_SESSION['message_1']='הי,<br> כאן מנתקים התחברות ממכשיר אחר';
	if(!isset($_SESSION['count']))
	{	
		$_SESSION['count'] = 1;
	}
	
// Data
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
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

	$U_name = $con->real_escape_string($_POST['user_name']);
	$P_ass = md5($con->real_escape_string($_POST['pass_word']));
	$_SESSION['u_n']=$U_name;
	$ip_address=$_SERVER['REMOTE_ADDR'];
	//DEBUGGING
	/*	echo '<pre>';
		echo $U_name;
		echo '<br>';
		echo $P_ass;
		echo '</pre>';
	*/	
	//report mail
		$e = "registration@explainit.online";		
		$f="registration@explainit.online";
		$f_1="".$U_name." מנסה לנתק חשבון אחר";
		$f_2=$ip_address;
		mail($f,$f_1,$f_2,"FROM:".$e);
	
	//checking count
	if($_SESSION['count']<4)
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


					
						$_SESSION['message_1'] = "התנתקות מוצלחת,";
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
						
						$sql = "INSERT INTO U_logs (U_N,U_M,LOGOUT_TIME,LOGOUT_DATE) VALUES ('$U_name','$IP','$logout_time','$date_logout')";
						$query_1 = mysqli_query($con,$sql);
						
						$sql = "SELECT LOGGED_IN FROM U_logged_in WHERE U_N = '$U_name'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						
						$code_3 = implode(" ",$row_1);
						
						// CHECKING CONNECTION FROM OTHER DEVICE
						if($code_3 == 'Y')
						{
							$sql = "UPDATE U_logged_in SET LOGGED_IN = 'N',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time',CODE = '$code_2', U_M='$IP', LOGGED_OUT='Y',LOGOUT_IP='N' WHERE U_N = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//OUTPUT
							header ("location: ../php/wl_fi/wlback_videos_2.php");
						}
						else
						{
							//OUTPUT
							header ('location: ../php/wl_fi/wlback_videos_2.php');
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
					$_SESSION['message_1']="אין מייל כזה<h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
					$_SESSION['count']++;
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
		$_SESSION['count'] = 0;
		
		//report mail
		$e = "registration@explainit.online";		
		$f="registration@explainit.online";
		$f_1="ל-".$U_name." יש בעיות עם החשבון";
		$f_2=$ip_address;
		mail($f,$f_1,$f_2,"FROM:".$e);
		
		//OUTPUT
		header ('location: ../php/error_fi/error_videos_3.php');
	}
}

?>
<head>
<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- OUTPUT -->
	<!-- favicon -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- OUTPUT -->
	<!-- APPLE TOUCH ICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- OUTPUT -->
	<!-- CSS -->
	<link rel="stylesheet" href="../css/2.css">
	<!-- General stuff -->
			<!-- Emoji CSS -->
			<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
			<!-- Jquery -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>

<body>
<div style="direction:rtl;text-align:center;">
	<h1 style="margin-bottom:0px;"><?=$_SESSION['message_1'] ?></h1>
	<i class="em em-writing_hand"></i>
		
	<!-- OUTPUT -->
	<form action="example_cleveland_l_videos_2.php" method="post" enctype="multipart/form-data" autocomplete="on">
		<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מייל" name="user_name" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" required><br>
		<div style="font-size:14px;"><a href="f_videos.php">שכחתי סיסמה</a></div>
		
		<div>
			<i id="p" class="em em-airplane"></i>
		</div>
		<input style="margin:4px auto;padding:2px;" type="submit" value="ניתוק מכשיר אחר" name="register">
	</form>
</div>

</body>