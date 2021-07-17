<?php
// SESSION START
	session_start();

// ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

// SSL
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}
	
// FUNCTIONS
	function valid($check)
	{
		if (mb_strlen($check)>=8)//checking length
		{
			return TRUE;
		}	
	}
	
	//FUNCTION TO GET HASHED USER CODE FROM TIMESTAMP AFTER 0 CHANGED
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
		
		//RETURNING THE ORIGINAL USER CODE AFTER HASHING
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
	mysqli_select_db($con, "elad189g_xo_course001_us"); 
	
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
	if ($_SERVER['REQUEST_METHOD'] == 'POST')//POST REQUEST SUBMITTED
	{
		// SANITIZING DATA
		$Us_name = $_SERVER['REMOTE_ADDR'];
		$Ma_name = $con->real_escape_string($_POST['e_mail']);
		$Pa_name = $con->real_escape_string($_POST['pass_word']);
		$Pa_2_name = $con->real_escape_string($_POST['pass_word_2']);
		
		// LOOKING FOR MAIL IN LIST
		$sql = "SELECT * FROM U_videos WHERE U_M = '$Ma_name'";
		$query = mysqli_query($con,$sql);
			
		//E-MAIL FOUND
		if(mysqli_num_rows($query) > 0)
		{
			$_SESSION['message_1']="יש כבר משתמש עם מייל כזה <br><h4 id='a_2' style='margin:2px auto;'>הכנס מייל אחר</h4>";
			
			//LOGIN LINK DISPLAYED
			echo '<script>setTimeout(function(){$("#c").click();}, 0001);</script>';
		}
		else//NO MAIL FOUND, CONTINUE SIGN UP
		{
			if($Pa_name==$Pa_2_name)//PASSWORDS MATCH
			{
				if (valid($Pa_name))//PASSWORD LONG ENOUGH
				{	
					// SAVING IP
					$U_name = $_SERVER['REMOTE_ADDR'];
					
					//SANITIZING //? WHY SECOND TIME
					$E_mail = $con->real_escape_string($_POST['e_mail']);
					$P_ass = md5($con->real_escape_string($_POST['pass_word']));
					$P_h = $con->real_escape_string(md5(rand(0,1100)));
						
					//SECURING
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
					
					//REGISTERING USER
					$sql = "INSERT INTO U_videos (U_N,U_M,U_P,U_Z,U_A,U_E,U_U,U_V,U_X,U_Y,U_T,U_IO) VALUES ('$U_name','$E_mail','$p_1','$p_2','1.png','$bytes_2','$bytes_0','$bytes_1','$bytes_3','$p_6','$p_4','$P_h')";
					$query = mysqli_query($con,$sql);
					
					//REGISTERING LOG IN
					$sql = "INSERT INTO U_logged_in (U_N,U_M,REGISTERED_IP) VALUES ('$E_mail','$U_name','$U_name')";
					$query = mysqli_query($con,$sql);
					
					//GETTING USER CODE ROW NUMBER FOR WRITE2DB FUNCTION
					$sql = "SELECT U_I FROM U_videos WHERE U_M = '$E_mail'";
					$query = mysqli_query($con,$sql);
					$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
					$h_g = implode(" ",$row);
					$_SESSION['u_i']=$h_g;
					
					//SESSION VAR
					$_SESSION['a'] = 1;
						
					//GETTING NEW DB DETAILS//OUTPUT 5
					include "../php/test_fi/test_po_5.php";
													
					//WRITING USER CODE TO DB FUNCTION
					// - GETS USER CODE, VAR OF NO USE, DATE IN HOUR-MIN-SEC, E-MAIL
					// - READS USER CODE FROM LOCAL FILE
					// - RETURNS USER CODE
					function write2db($t,$u,$y,$h)
					{
						//CONNECTING//DATABASE
						//ATTRIBUTES
						$host = 'localhost';
						$username = 'elad189g_xo_course001';
						$password = 'Wonderfull5600';
						$db = 'elad189g_xo_course001_us';
						
						//CREATING SUCCESS FLAG
						$flag_write2db = 0;
						
						//CREATING CONNECTION
						$con = mysqli_connect($host, $username, $password,$db);
						
						//GETTING USER ROW NUMBER
						$u = $_SESSION['u_i'];
						
						//GETTING HASHED USER CODE
						$v = set_num($t);
						
						//SQL
						//REGISTERING REGISTRATION UNIX TIMESTAMP AFTER 0 CHANGED
						$sql = "UPDATE U_videos SET U_T1 = '$t' WHERE U_I = '$u'";
						$query = mysqli_query($con,$sql);
						
						//UPDATING SUCCESS FLAG UPON SUCCESS
						if($query)
						{
							$flag_write2db++;
						}
						
						//REGISTERING REGISTRATION TIMESTAMP DATE-HOURS-MINS-SECS
						$sql = "UPDATE U_videos SET U_T2 = '$y' WHERE U_I = '$u'";
						$query = mysqli_query($con,$sql);
						
						//UPDATING SUCCESS FLAG UPON SUCCESS
						if($query)
						{
							$flag_write2db++;
						}
						
						//REGISTERING HASHED USER CODE
						$sql = "UPDATE U_videos SET CODE = '$v' WHERE U_I = '$u'";
						$query = mysqli_query($con,$sql);
						
						//UPDATING SUCCESS FLAG UPON SUCCESS
						if($query)
						{
							$flag_write2db++;
						}
						
						//UPDATING HASHED USER CODE IN LOGIN TABLE//-> CHANGING WAY OF WORK TO ALLOW LOGGING NEEDED
						$sql = "UPDATE U_logged_in SET CODE = '$v' WHERE U_N = '$h'";
						$query = mysqli_query($con,$sql);
						
						//UPDATING SUCCESS FLAG UPON SUCCESS
						if($query)
						{
							$flag_write2db++;
						}
						
						//RETURNING 1 IF REGISTRATION SUCCESSFUL
						if($flag_write2db == 4)
						{
							return 1;
						} 
						else//REGISTRATION FAILED
						{
							return 0;
						}
					}
					
					//GETTING CURRENT DATE (VAR USED IN TEST_PO_5.PHP)
					$na=date('Y-m-d-His');
					
					//WRITING USER CODE TO DB
					$flag_registration = write2db($t_s,'hof',$na,$E_mail);
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
					//? should be IF WRITE2DB SUCCESSFUL, REDIRECT TO WELCOME PAGE
					if($flag_registration)
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
						//REPORT MAIL//OUTPUT 6//MAIL 1
						//ATTRIBUTES
						$f = "registration@explainit.online";
						$f_1="Explainit Online - קורס 001 - נרשם/ת חדש/ה";
						$t=$E_mail;
						
						//? NOT NEEDED
						$f_2="מייל:/r/n".$t."/r/n כתובת IP:".$_SESSION['u_n'];
						$e = "registration@explainit.online";
							
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
						mail($f,$f_1,$message,$headers);
						
					/* HTML MAIL WITH PHP *//* https://css-tricks.com/sending-nice-html-email-with-php/ */
						
						//CONFIRMATION MAIL//OUTPUT 7//MAIL 2
						//ATTRIBUTES
						$t=$E_mail;
						$s="Explainit Online - קורס 001 - אישור חשבון";
						
						//HEADERS
						$headers = "From: registration@explainit.online\r\n";
						$headers .= "Reply-To:registration@explainit.online\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=utf-8\r\n";
						
						
						//MESSAGE
						$message = '<html lang="iw" dir="rtl"><body>';
						$message .= '<img style="width:100%;" src="https://www.course001.explainit.online/img/mail/welcome.png" alt="ברוך/ה הבא/ה" />';
						$message .= '<div style="width:100%;margin:auto;text-align:center;">';
						$message .= '<h4>לאישור החשבון:</h4>';
						//<a href="https://www.course001.explainit.online/php/v_fi/v_videos.php?e='.$t.'&h='.$P_h.'">
						$message .= '<div style="width:50%;margin:auto;">
										<a href="https://www.course001.explainit.online/php/v_fi/v_videos.php?e='.$t.'&h='.$P_h.'">
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
						mail($t,$s, $message, $headers);
							
						//SESSION VAR 
						$_SESSION['v_wait'] = 1;
						
						//OUTPUT 8
						header("location: ../php/v_fi/v_videos.php");
					}//USER REGISTRATION SUCCESSFUL
					
					else//USER CODE REGISTRATION FAILED
					{
						//MESSAGE
						$_SESSION['message_1']="הרשמה לא מוצלחת";
						
						//OUTPUT 9
						header("location: ../php/error_fi/error_videos.php");
					}
				}//PASSWORD NOT LONG ENOUGH
				else
				{
					//MESSAGE
					$_SESSION['message_1']="סיסמה לא ארוכה מספיק <br><h4 id='a_1' style='margin:2px auto;'>(צריך מינימום 8 אותיות ומספרים)</h4>";
					
					//REFILL INPUT FIELD
					echo '<script>setTimeout(function(){$("#a_1").click();}, 0001);</script>';
				}   
			}//PASSWORDS DON'T MATCH
			else
			{
				//MESSAGE
				$_SESSION['message_1']="הסיסמאות לא מתאימות<h4 id='a_1' style='margin:2px auto;'>נסה/י שוב</h4>";
				
				//REFILL INPUT FIELD
				echo '<script>setTimeout(function(){$("#a_1").click();}, 0001);</script>';
			}
		}
	}


?>
<head>

	<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 1 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 2 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 3 -->
	<link rel="stylesheet" href="../css/2.css">
	
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
		background: #A9014B url(../css/button_overlay.png) repeat-x scroll 0 0;/*OUTPUT 4*/
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

/* W3SCHOOLS CUSTOM CHECKBOX */	
/* The container *//* https://www.w3schools.com/howto/howto_css_custom_checkbox.asp */
.container {
    display: block;
    position: relative;
    padding-right: 35px;/* CHANGED FROM: padding-left: 35px; */
    /* margin-bottom: 12px; CANCELED; */
    cursor: pointer;
    /* font-size: 22px; CANCELED; */
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    right: 0;/* CHANGED FROM: left: 0; */
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>
<!-- Hotjar Tracking Code for https://course001.explainit.online -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1287837,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>

<body>
<div style="direction:rtl;text-align:center;">
	<h1 style="margin-bottom:0px;">הרשמה</h1>
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<h4 id='u_1' style="margin:0px auto;"><?=$_SESSION['message_1'] ?></h4>
	
	<i class="em em-writing_hand"></i>
	
	<!-- OUTPUT 10 -->
	<form action="example_cleveland.php" method="post" enctype="multipart/form-data" autocomplete="on">
		
		<input id="input_2" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="email" placeholder="מייל" name="e_mail" onfocus="tell_mail()" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" onfocus="tell_pass()" required><br>
		<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה מחדש" name="pass_word_2" autocomplete="new-password" onfocus="tell_pass_2()" required><br>
			
		<div style="width:200px;text-align:right;direction:rtl;margin:auto;">
			<label class="container">
			אני מסכים/ה ל<!-- TERMS OF SERVICE --><!-- OUTPUT 11 --><a href="../terms/Terms_of_Service_04.08.18.pdf" target="_blank">תנאי השימוש</a> ול<!-- PRIVACY STATEMENT --><!-- OUTPUT 12 --><a href="../terms/Privacy_Statement_02.08.18.pdf" target="_blank">מדיניות הפרטיות</a>.
				<input id="terms_1" type="checkbox">
				<span class="checkmark"></span>
			</label>
			
			<label class="container">
			לאחר צפיה בסרטוני הדמו אני מאשר/ת שמצאתי את הקורס מתאים לצרכיי, ואני מודע/ת לכך שעקב אופיו של המוצר אין אפשרות לקבל החזר כספי או לבטל עסקה לאחר קניית הקורס.
				<input id="terms_2" type="checkbox">
				<span class="checkmark"></span>
			</label>
			
			<label class="container">
			התשלום הוא עבור מנוי לתמיד. 
				<input id="terms_3" type="checkbox">
				<span class="checkmark"></span>
			</label>
		</div>	
		
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<div id="c">
			<i id="p" class="em em-airplane"></i>
		</div>
		
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			<input class="responsive_input_4 button" style="width:100%;" type="submit" value="הרשמה" name="register" onclick="return testcheck()">
		</div>
	</form>
	
	<div id="a_9" style="display:none;">
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<h4 style="margin:0px 0px 5px 0px;">התחברות זה בלינק הזה:</h4>
		
		<!-- BUTTON -->
		<div style="width:25%;margin:auto;">
			
			<!-- OUTPUT 13 -->
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

//FUNCTION TO CHECK IF BOTH TERMS AND PRIVACY CHECKBOXES ARE CHECKED
//- GETS NOTHING.
//- CHECKS IF CHECKBOXES AE CHECKED.
//- RETURNS TRUE IF BOTH ARE CHECKED AND FALSE IF NOT.
function testcheck()
{
    //VAR
	var term_case = 0;
	
	//3 STATEMENTS ARE UNCHECKED
	if (!jQuery("#terms_1").is(":checked") && !jQuery("#terms_2").is(":checked") && !jQuery("#terms_3").is(":checked"))
	{
        //ALERT
		alert("חובה לאשר את תנאי השימוש והצהרת הפרטיות, את ההצהרה שאת/ה מבין/ה שעקב אופי המוצר לא יהיה אפשרות לבטל את העסקה ושמדובר במנוי לתמיד.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
	
	//2 STATEMENTS ARE UNCHECKED
	if (!jQuery("#terms_1").is(":checked") && !jQuery("#terms_2").is(":checked"))
	{
        //ALERT
		alert("חובה לאשר את תנאי השימוש והצהרת הפרטיות, את ההצהרה שאת/ה מבין/ה שעקב אופי המוצר לא יהיה אפשרות לבטל את העסקה.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
    
	//2 STATEMENTS ARE UNCHECKED
	if (!jQuery("#terms_1").is(":checked") && !jQuery("#terms_3").is(":checked"))
	{
        //ALERT
		alert("חובה לאשר את תנאי השימוש והצהרת הפרטיות, ושמדובר במנוי לתמיד.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
	
	//2 STATEMENTS ARE UNCHECKED
	if (!jQuery("#terms_2").is(":checked") && !jQuery("#terms_3").is(":checked"))
	{
        //ALERT
		alert("חובה לאשר את ההצהרה שאת/ה מבין/ה שעקב אופי המוצר לא יהיה אפשרות לבטל את העסקה ושמדובר במנוי לתמיד.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
	
	//STATEMENT 1 IS UNCHECKED
	if (!jQuery("#terms_1").is(":checked") && (term_case == 0))
	{
        //ALERT
		alert("חובה לאשר את תנאי השימוש והצהרת הפרטיות.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
	
	//STATEMENT 2 IS UNCHECKED
	if (!jQuery("#terms_2").is(":checked") && (term_case == 0))
	{
        //ALERT
		alert("חובה לאשר את ההצהרה שאת/ה מבין/ה שעקב אופי המוצר לא יהיה אפשרות לבטל את העסקה או לקבל החזר כספי.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
	
	//STATEMENT 3 IS UNCHECKED
	if (!jQuery("#terms_3").is(":checked") && (term_case == 0))
	{
        //ALERT
		alert("חובה לאשר את ההצהרה שאת/ה מבין/ה שמדובר במנוי לתמיד.");
        
		//PASSED THROUGH HERE
		term_case = 1;
		
		//RETURN FALSE
		return false;
    }
	
	//BOTH STATEMENTS ARE CHECKED
	return true;
}
</script>
</body>