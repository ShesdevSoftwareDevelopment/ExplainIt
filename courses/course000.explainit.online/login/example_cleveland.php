<head>

<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- favicon --><!-- OUTPUT -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT -->
	<link rel="stylesheet" href="../css/2.css">
	
	<!-- General stuff -->
			<!-- Emoji CSS -->
			<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
			<!-- Jquery -->
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
		background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;/*OUTPUT*/
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

<?php
//Session start
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
	
// Functions
	function valid($check)
	{
		if (mb_strlen($check)>=8)//checking length
		{
			return TRUE;
		}	
	}
	
	function set_num($m)
	{

		//DEBUGGING	
		//echo '<pre style="direction:ltr;">';
		//echo 'm:<br>';
		//var_dump($m);
		
		$b = substr($m, 0, -1);//getting 0- before last chars in $m
		
		$a[0]= intval(substr($m, -1));//getting last char in $m and turning it to int

		//DEBUGGING
		//echo 'a:<br>';
		//var_dump($a);
		
		for($i=1;$i<10;$i++)//creating array of completing 0-9 last chars
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

		//DEBUGGING		
		//echo 'a after loop:<br>';
		//var_dump($a);
		
		for($i=0;$i<10;$i++)//creating completing $m's
		{
			$b_array[$i] = $b.$a[$i];
		}

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
		$c[6]=$b_array[0];
		$c[7]=$b_array[1];
		$c[8]=$b_array[2];
		$c[9]=$b_array[3];
		
		//HASHING
		
		for($i=0;$i<count($c);$i++)//md5
		{
			$d[$i] = md5($c[$i]);
		}
		
		//DEBUGGING
		/*	echo '<pre style="direction:ltr;">';
			echo 'count_c:<br>';
			echo count($c);
			echo 'd:<br>';
			var_dump($d);
		*/
		
		//CHANGING a's
		for($i=0;$i<count($d);$i++)
		{
			for($j=0;$j<strlen($d[$i]);$j++)
			{
				$f=substr($d[$i], $j, 1);//every char on its own
				
				if($j == 0)
				{
					$e[$i]=$f;
					continue;
				}	
				
				if($f=='a')
				{
					$e[$i]=$e[$i].'p';
				}
				else
				{
					$e[$i]=$e[$i].$f;
				}
				
			}
		}
		//DEBUGGING
		/*	echo '<br>';
			var_dump($e);
			echo '</pre>';		
		*/		
		return $e[6];
	}
	
//	Vars
	$_SESSION['message_1']="בוא/י נתחיל";
	$Us_name = '';
	$Ma_name = '';

// SELF POST
	// DATABASE
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

	//IF
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		// Sanitizing
		$Us_name = $_SERVER['REMOTE_ADDR'];
		$Ma_name = $con->real_escape_string($_POST['e_mail']);
		$Pa_name = $con->real_escape_string($_POST['pass_word']);
		$Pa_2_name = $con->real_escape_string($_POST['pass_word_2']);
		
		//Existing mail search
		$sql = "SELECT * FROM U_videos WHERE U_M = '$Ma_name'";
		$query = mysqli_query($con,$sql);
			
		if(mysqli_num_rows($query) > 0)//E-MAIL FOUND
		{
			$_SESSION['message_1']="יש כבר משתמש עם מייל כזה <br><h4 id='a_2' style='margin:2px auto;'>הכנס מייל אחר</h4>";
			echo '<script>setTimeout(function(){$("#c").click();}, 0001);</script>';
		}
		else//No such mail, continue
		{
			if($Pa_name==$Pa_2_name)//Passwords match
			{
				if (valid($Pa_name))//Password long enough
				{	
					$U_name = $_SERVER['REMOTE_ADDR'];// SAVING IP
					$E_mail = $con->real_escape_string($_POST['e_mail']);
					$P_ass = md5($con->real_escape_string($_POST['pass_word']));
					$P_h = $con->real_escape_string(md5(rand(0,1100)));
						
					//Securing
					$bytes_0 = bin2hex(random_bytes(5));
					$bytes_1 = bin2hex(random_bytes(5));
					$bytes_2 = bin2hex(random_bytes(5));
					$bytes_3 = bin2hex(random_bytes(5));
					$bytes_4 = bin2hex(random_bytes(5));
					
					$bytes_4 = md5($bytes_4);
					
					$p_0 = $bytes_1.$bytes_4.$bytes_0;
					$p_2 = md5($p_0);
					
					$p_3 = $bytes_2.$bytes_4.$bytes_3;
					$p_4 = md5($p_3);
					
					$p_5 = $bytes_0.$bytes_4.$bytes_4;
					$p_6 = md5($p_5);
					
					$p = $bytes_0.$P_ass.$bytes_2;
					$p_1 = md5($p);
					
					$_SESSION['a_p']='av/1.png';
					$_SESSION['u_n'] = $U_name;
					
					$sql = "INSERT INTO U_videos (U_N,U_M,U_P,U_Z,U_A,U_E,U_U,U_V,U_X,U_Y,U_T,U_IO) VALUES ('$U_name','$E_mail','$p_1','$p_2','1.png','$bytes_2','$bytes_0','$bytes_1','$bytes_3','$p_6','$p_4','$P_h')";
					$query = mysqli_query($con,$sql);
					
					$sql = "INSERT INTO U_logged_in (U_N,U_M,REGISTERED_IP) VALUES ('$E_mail','$U_name','$U_name')";
					$query = mysqli_query($con,$sql);
					
					//creating user code
					$sql = "SELECT U_I FROM U_videos WHERE U_M = '$E_mail'";
					$query = mysqli_query($con,$sql);
					$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
					$h_g = implode(" ",$row);
					$_SESSION['u_i']=$h_g;
					
					//creating user folder
					$_SESSION['a'] = 1;
					//$p = '../../s/srhair.com/files';
					$p = '../php/test_fi';
					$_SESSION['r']=$p;
					//OUTPUT
					include "$p/test_po_5.php";
													
										
					// Writing to db
					function write2db($t,$u,$y,$h)
					{
						//DATABASE
						//data
						$host = 'localhost';
						$username = 'elad189g_xo_course001';
						$password = 'Wonderfull5600';
						$db = 'elad189g_xo_course001_us';
						
						// creating Connection
						$con = mysqli_connect($host, $username, $password,$db);
						
						//user name
						$u = $_SESSION['u_i'];
						$v = set_num($t);
						
						//sql
						$sql = "UPDATE U_videos SET U_T1 = '$t' WHERE U_I = '$u'";
						$query = mysqli_query($con,$sql);
						
						$sql = "UPDATE U_videos SET U_T2 = '$y' WHERE U_I = '$u'";
						$query = mysqli_query($con,$sql);
						
						$sql = "UPDATE U_videos SET CODE = '$v' WHERE U_I = '$u'";
						$query = mysqli_query($con,$sql);
						
						$sql = "UPDATE U_logged_in SET CODE = '$v' WHERE U_N = '$h'";
						$query = mysqli_query($con,$sql);
						
					}
					
					//getting timestamp
					$t_s = strval(microtime_float());
					$t_s = change_0($t_s);
					$na=date('Y-m-d-His');
					$nam=date('Y-m-d-His-').$t_s;
						
					write2db($t_s,'hof',$na,$E_mail);
					
/*
					//debugging
						
						echo '<pre style="background:white;color:black;margin-top:3px;text-align:center;border:2px black solid;">';
						//8echo '<h3 style="margin:0px auto;"><u>b_0:</u></h3>';
						//8var_dump($bytes_0);
						//8var_dump($bytes_1);
						//8var_dump($bytes_2);
						//8var_dump($bytes_3);
						//8var_dump($bytes_4);
						//8echo '<h3 style="margin:0px auto;"><u>query:</u></h3>';
						//8var_dump($query);
						//8echo '<h3 style="margin:0px auto;"><u>con:</u></h3>';
						//8var_dump($con);
						echo '</pre>';
*/
					
					//if query successful, redirect to welcome page
					if($query)
					{
						$_SESSION['message_1']="הרשמה מוצלחת";
						$_SESSION['message_2']="כדי להפעיל את החשבון לחץ על הקישור שנשלח במייל";
						
												
						//confirmation mail - OLDER VERSION
					/*	$t=$E_mail;
						$s="אישור חשבון explainit.online";
						$m=' הי, אשר/י את החשבון בלחיצה על הלינק:
						http://www.explainit.online/s1/s8_videos/login/v_videos.php?e='.$t.'&h='.$P_h;				
						$m = wordwrap($m,70);
						$e = "registration@explainit.online";
						mail($t,$s,$m,"FROM:".$e."\r\n"."Content-Type: text/html;charset=utf-8");
					*/	
						// MAIL
						//VARS
						$t=$E_mail;
						$e = "registration@explainit.online";
						
						//REPORT MAIL
						
						//HEADERS
						$headers = "From: registration@explainit.online\r\n";
						$headers .= "Reply-To:registration@explainit.online\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						//MESSAGE
						$message = '<html lang="iw" dir="rtl"><body>';
						$message .= '<div style="width:100%;margin:auto;text-align:center;">';
						$message .= '<h4>מייל:</h4>';
						$message .= '<h4>'.$t.'</h4>';
						$message .= '<h4>IP:</h4>';
						$message .= '<h4>'.$_SESSION['u_n'].'</h4>';
						$message .= "</div>";
						$message .= "</body></html>";
						
						//SENDING
						$f = "registration@explainit.online";
						$f_1="נרשם/ת חדש/ה";
						$f_2="מייל:/r/n".$t."/r/n כתובת IP:".$_SESSION['u_n'];
						mail($f,$f_1,$message,$headers);
						
					/* HTML MAIL WITH PHP *//* https://css-tricks.com/sending-nice-html-email-with-php/ */
						
						//HEADERS
						$headers = "From: registration@explainit.online\r\n";
						$headers .= "Reply-To:registration@explainit.online\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						//MAIL//OUTPUT IN MAIL
						//MESSAGE
						$message = '<html lang="iw" dir="rtl"><body>';
						$message .= '<img style="width:100%;" src="https://www.course001.explainit.online/img/mail/welcome.png" alt="ברוך/ה הבא/ה" />';
						$message .= '<div style="width:100%;margin:auto;text-align:center;">';
						$message .= '<h4>לאישור החשבון:</h4>';
						$message .= '<div style="width:50%;margin:auto;">
										<a href="https://www.course001.explainit.online/login/v_videos.php?e='.$t.'&h='.$P_h.'">
											<button style="width:100%;
  														border-radius: 5px;
  														-moz-border-radius: 5px;
  														-webkit-border-radius: 5px;
  														display: inline-block;
  														color: white;
  														padding: 5px 10px 5px;
  														white-space: nowrap;
  														text-decoration: none;
  														cursor: pointer;
  														background: #A9014B;
  														border-style: none;
  														text-align: center;
  														overflow: visible;"
											>אישור</button>
										</a>
									</div>';
						$message .= "</div>";
						$message .= "</body></html>";
						
						//SENDING
						$t=$E_mail;
						$s="אישור חשבון explainit.online";
						mail($t,$s, $message, $headers);
							
						
						$_SESSION['v_wait'] = 1;
						//OUTPUT
						header("location: ../php/v_fi/v_videos.php");
					}
					else
					{
						$_SESSION['message_1']="הרשמה לא מוצלחת";
						//OUTPUT
						header("location: ../php/error_fi/error_videos.php");
					}
				}//Password not long enough
				else
				{
					$_SESSION['message_1']="סיסמה לא ארוכה מספיק <br><h4 id='a_1' style='margin:2px auto;'>(צריך מינימום 8 אותיות ומספרים)</h4>";
					echo '<script>setTimeout(function(){$("#a_1").click();}, 0001);</script>';
				}   
			}//Passwords don't match
			else
			{
				$_SESSION['message_1']="הסיסמאות לא מתאימות<h4 id='a_1' style='margin:2px auto;'>נסה שוב</h4>";
				echo '<script>setTimeout(function(){$("#a_1").click();}, 0001);</script>';
			}
		}
	}


?>

<body>
<div style="direction:rtl;text-align:center;">
	<h1 style="margin-bottom:0px;">הרשמה</h1>
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<h4 id='u_1' style="margin:0px auto;"><?=$_SESSION['message_1'] ?></h4>
	
	<i class="em em-writing_hand"></i>
	
	<!-- OUTPUT -->
	<form action="example_cleveland.php" method="post" enctype="multipart/form-data" autocomplete="on">
		
		<input id="input_2" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="email" placeholder="מייל" name="e_mail" onfocus="tell_mail()" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" onfocus="tell_pass()" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה מחדש" name="pass_word_2" autocomplete="new-password" onfocus="tell_pass_2()" required><br>
			
		<div id="c">
			<i id="p" class="em em-airplane"></i>
		</div>
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="הרשמה" name="register">
		</div>
	</form>
	
	<div id="a_9" style="display:none;">
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<h4 style="margin:0px 0px 5px 0px;">התחברות זה בלינק הזה:</h4>
		
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			
			<!-- OUTPUT -->
			<a href="example_cleveland_l_videos.php">
				<input class="responsive_input_4 button" style="width:100%;" type="submit" value="התחברות" name="register">
			</a>
		</div>
	</div>
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<div style="width:75%;margin:auto;text-align:center;"> 
		כאן אנחנו פותחים לכם חשבון שתוכלו להיכנס איתו על מנת לצפות בסרטונים אחרי ששילמתם.
		<br>
		<br>
		חשוב לזכור את ה<b>מייל</b> וה<b>סיסמה</b> כי איתם תיכנסו.
	</div>
	
</div>

<script>

$("#a_1").click(function(){
	$("#input_2").val('<?= $Ma_name ?>');
});

$("#a_3").click(function(){
	$("#input_2").val('<?= $Ma_name ?>');
});

function tell_mail()
{
	$("#u_1").html('איתו את/ה עושה לוגין');
}
function tell_pass()
{
	$("#u_1").html('לפחות 8 אותיות ומספרים');
}
function tell_pass_2()
{
	$("#u_1").html('לפחות 8 אותיות ומספרים');
}

$("#c").click(function(){
	document.getElementById("a_9").style.display="block";
});

</script>
</body>