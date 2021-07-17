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
$course_number_="006";

//VARS	
	//LOCAL VARS
	$U_name = '';
	
	//SESSION VARS
	$_SESSION['loggedin'] = 0;
	$_SESSION['message_1']='התחברות';
	$_SESSION['from_login_page'] = 3;
	
	if(!isset($_SESSION['count']))
	{	
		$_SESSION['count'] = 1;
	}

//FUNCTIONS
	function check_length($str)
	{
		//CHECKING LENGTH
		if (mb_strlen($str)>=8)
		{
			return TRUE;
		}	
	}

//DATABASE
//POST REQUEST WAS MADE TO REACH THE PAGE
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
	
	//SANITIZING
	$U_name = $con->real_escape_string($_POST['user_name']);
	$P_ass = md5($con->real_escape_string($_POST['pass_word']));
	
	$name=$con->real_escape_string($_POST['user_name']);
	$password=$con->real_escape_string($_POST['pass_word']);
		
	$_SESSION['u_n']=$U_name;
	$ip_address=$_SERVER['REMOTE_ADDR'];
	
	//DEBUGGING
	/*	echo '<pre>';
		echo $U_name;
		echo '<br>';
		echo $P_ass;
		echo '</pre>';
	*/	
	//USER TRIED LOGGING IN LESS THAN 3 TIMES
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
			
			//FOUND MAIL IN TABLE
			if (mysqli_num_rows($query) > 0)
			{	
				//CHECKING ACTIVATION
				if($row['U_AP'] == 1)
				{
					//USER ACCOUNT ACTIVATED, VALIDATING PASSWORD
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
					
					//PASSWORD MATCHES TO PASSWORD IN TABLE
					if(mysqli_num_rows($query) > 0)
					{
						
						if(!empty($_POST["remember"]))   
						{  
							setcookie ("member_login",$name,time()+ (10 * 365 * 24 * 60 * 60));  
							setcookie ("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
							$_SESSION["admin_name"] = $name;
						}  
						else  
						{  
							if(isset($_COOKIE["member_login"]))   
							{  
								setcookie ("member_login","");  
							}  
							if(isset($_COOKIE["member_password"]))   
							{  
								setcookie ("member_password","");  
							}  
					   }
						
						//GETTING USER IP ADDRESS
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
						
						//SESSION VARS
						$_SESSION['message_1'] = "התחברות מוצלחת,";
						$_SESSION['loggedin'] = 1;
						
						//GETTING USER CODE
						$sql = "SELECT U_T1 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$_SESSION['timestamp'] = implode(" ",$row_1);
						$code_1=$_SESSION['timestamp'];
						
						//GETTING HASHED USER CODE//? NEEDED
						$sql = "SELECT CODE FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$code_2 = implode(" ",$row_1);
						
						//GETTING SIGN UP DATE-HOURS-MINS-SECS//? NEEDED
						$sql = "SELECT U_T2 FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row_2 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$_SESSION['dir_01'] = implode(" ",$row_2);
						$_SESSION['directory'] = $_SESSION['dir_01']."-".$_SESSION['timestamp'];
						
						//DEBUGGING
						/*
						echo '<pre>';
						var_dump($row_1);
						echo '<br>';
						var_dump($row_2);
						echo '</pre>';
						*/
						
						//UPDATING LOGS
						//IP ADDRESS
						$IP=$_SERVER['REMOTE_ADDR'];
						
						//LOGIN TIME
						date_default_timezone_set('Asia/Jerusalem');
						$login_time = time();
						$date_login = date('m/d/Y h:i:s a', time());
												
						//LOGOUT TIME
						date_default_timezone_set('Asia/Jerusalem');
						$logout_time = time()+(3600);//1 hour later
						$date_logout = date('m/d/Y h:i:s a', $logout_time);
						
						//UPDATING CURRENT LOG IN ATTEMPT INTO U_logs
						$sql = "INSERT INTO U_logs (U_N,U_M,LOGIN_DATE,LOGIN_TIME,LOGOUT_TIME,LOGOUT_DATE,PAGE) VALUES ('$U_name','$IP','$date_login','$login_time','$logout_time','$date_logout','L_01')";
						$query_1 = mysqli_query($con,$sql);
						
						//GETTING CURRENT LOGGED IN STATUS
						$sql = "SELECT LOGGED_IN FROM U_logged_in WHERE U_N = '$U_name'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$code_3 = implode(" ",$row_1);
						
						//GETTING THE IP REGISTERED WITH
						$sql = "SELECT REGISTERED_IP FROM U_logged_in WHERE U_N = '$U_name'";
						$query = mysqli_query($con,$sql);
						$row_001 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$original_ip = implode(" ",$row_001);
						$_SESSION['original_ip']=$original_ip;
						
						//CHECKING "NEEDS TO PAY"
						$sql = "SELECT PAID FROM U_videos WHERE U_M = '$U_name' AND U_P ='$p_2'";
						$query = mysqli_query($con,$sql);
						$row_1 = mysqli_fetch_array($query,MYSQLI_ASSOC);
						$code_4 = implode(" ",$row_1);
						//SESSION VAR
						$_SESSION['paid']=$code_4;
						
						//CHECKING CONNECTION FROM OTHER DEVICE
						if($code_3 == 'N')
						{
							//USER ISN'T LOGGED IN FROM ANOTHER DEVICE
							//UPDATING logged_in WITH CURRENT LOG IN 
							$sql = "UPDATE U_logged_in SET LOGGED_IN = 'Y',LOGIN_DATE = '$date_login',LOGIN_TIME = '$login_time',LOGOUT_DATE = '$date_logout',LOGOUT_TIME = '$logout_time',CODE = '$code_2', U_M='$IP', LOGGED_OUT='N',LOGOUT_IP='N' WHERE U_N = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//UPDATING U_LI WITH CURRENT LOG IN 
							$sql = "UPDATE U_videos SET U_LI = '1',LOGOUT_TIME = '$logout_time' WHERE U_M = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//UPDATING U_TP WITH CURRENT LOG IN 
							$sql = "UPDATE U_videos SET U_TP = '0' WHERE U_M = '$U_name'";
							$query_2 = mysqli_query($con,$sql);
							
							//REPORT MAIL//OUTPUT//LOGIN
							
							$f = "fiveminutes003@gmail.com, registration@explainit.online";
							$f_1="XO - ".$course_number_." - LOGIN";
							
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
							$message .= '<h4>'.$IP.'</h4>';
							$message .= "</div>";
							$message .= "</body></html>";
							
							//SENDING
							mail($f,$f_1,$message,$headers);
													
							//OUTPUT 05
							header ("location: ../php/wl_fi/wlback_videos.php");
						}
						//USER IS LOGGED IN FROM ANOTHER DEVICE
						else
						{
							//ATTRIBUTES//OUTPUT 02
							$f = "registration@explainit.online";
							$f_1="Explainit Online - קורס ".$course_number_." - ניסיון התחברות ממכשיר אחר";
									
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
							$message .= '<h4>IP בהרשמה:</h4>';
							$message .= '<h4>'.$original_ip.'</h4>';
							$message .= '<h4>IP:</h4>';
							$message .= '<h4>'.$ip_address.'</h4>';
							$message .= "</div>";
							$message .= "</body></html>";
							
							//SENDING
							mail($f,$f_1,$message,$headers);
							
							//OUTPUT 06
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
					//PASSWORD DOESN'T MATCH THE PASSWORD IN TABLE
					else
					{
						//SESSION VARS
						$_SESSION['message_1']="סיסמה לא נכונה";
						$_SESSION['count']++;
						
						//SLEEP
						sleep(2);
					}	
				}
				//USER HASN'T ACTIVATED ACCOUNT
				else
				{
					//SESSION VARS
					$_SESSION['v_wait'] = 1;
					
					//OUTPUT 07
					header ('location: ../php/v_fi/v_videos.php');
				}
			}
			//MAIL ISN'T FOUND IN TABLE
			else
			{
				//USER INSERTED MAIL
				if(isset($U_name)&&$U_name!='')
				{
					//SESSION VARS
					$_SESSION['message_1']="אין מייל כזה<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב או לחצ/י למטה להרשמה</h4>";
					$_SESSION['count']++;
					
					//SHOWING LINK TO SIGN UP PAGE//OUTPUT 08
					echo '<script>setTimeout(function(){document.getElementById("c").click();}, 4000);</script>';
					
					//SLEEP
					sleep(2);
				}
				//USER HASN'T INSERTED MAIL
				else
				{
					//SESSION VARS
					$_SESSION['message_1']="לא הכנסת מייל<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
					$_SESSION['count']++;
					
					//SLEEP
					sleep(2);
				}
			}
		}
		//PASSWORD NOT LONG ENOUGH
		else
		{
			//SESSION VARS
			$_SESSION['message_1']="סיסמה לא נכונה<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
			$_SESSION['count']++;
			
			//SLEEP
			sleep(2);
		}
	}
	//USER TRIED LOGGING IN MORE THAN 3 TIMES
	else
	{
		$_SESSION['count'] = 0;
		
		//REPORT MAIL//? CHANGE TO MAIL ADDRESS//OUTPUT 09
				
		//ATTRIBUTES
		$f = "registration@explainit.online";
		$f_1="Explainit Online - קורס ".$course_number_." - בעיות עם החשבון";
				
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
		
		//OUTPUT 10
		header ('location: ../php/error_fi/error_videos_3.php');
	}
}

?>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- TITLE -->
	<title>פיזיקה לבגרות | מכניקה | התחברות</title>
		
	<!-- DESCRIPTION -->
	<meta name="description" content='LOGIN'>
		
	<!-- FAVICON --><!-- OUTPUT 01 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 02 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 03 -->
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
		background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 04 */
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
	
	.no_show
	{
		display:none;
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
body
	{
		/* Background pattern from Toptal Subtle Patterns */
		/* background-image:url(../img/background/grey_wash_wall.png); */
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
	
html
	{
		background-color:#2a6456;
	}
</style>

	<!-- Hotjar Tracking Code for https://course006.explainit.online -->
	<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1439577,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>			
</head>
<body>
	<div style="direction:rtl;text-align:center;">
		<!-- HEADER -->
		<h1 id="c" style="margin-bottom:0px;color:#faae1d;"><?=$_SESSION['message_1'] ?></h1>
		
		<!-- HORIZONTAL LINE -->
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<!-- EMOJI -->
		<i class="em em-writing_hand"></i>
			
		<!-- OUTPUTS 11,12 -->
		<form action="example_cleveland_l_videos.php" method="post" enctype="multipart/form-data" autocomplete="on" style="margin-bottom:0px;">
			<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מייל" name="user_name" autocomplete="mail" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" required><br>
			<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" value="<?php if(isset($_COOKIE["member_password"])) { echo $_COOKIE["member_password"]; } ?>" required><br>
			<p style="direction:ltr;">      
				<input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />  
		        <label for="remember-me">Remember me</label> 
			</p>
			<div style="font-size:14px;"><!-- OUTPUT 11 --><a style="color:#faae1d;" href="f_videos.php">שכחתי סיסמה</a></div>
			<div style="font-size:14px;"><!-- OUTPUT 12 --><a style="color:#faae1d;" href="example_cleveland_l_videos_4_multi.php">אישור תשלום</a></div>
			
			<!-- EMOJI -->
			<div>
				<i id="p" class="em em-airplane"></i>
			</div>
			
			<!-- BUTTON -->
			<div style="width:50%;margin:auto;">
				<input class="responsive_input_4 button" style="width:100%;" type="submit" value="התחבר/י" name="register">
			</div>
		</form>
		
		<!-- LINK TO SIGN UP PAGE -->
		<div id="a_8" class="no_show">
			<div style="width:75%;margin:auto;">
				<hr>
			</div>
			
			<h4 style="margin:0px 0px 5px 0px;">להרשמה:</h4>
			
			<!-- BUTTON --><!-- OUTPUT 08 -->
			<div style="width:50%;margin:auto;">
				<a href="example_cleveland.php">
					<input class="responsive_input_4 button" style="width:100%;" type="submit" value="לחצ/י להרשמה" name="register">
				</a>
			</div>
		</div>
	</div>

<script>
$("#a_1").click(function(){
	$("#input_1").val('<?= $U_name ?>');
});

$("#c").click(function(){
	$("#a_8").removeClass("no_show");
});
</script>
</body>