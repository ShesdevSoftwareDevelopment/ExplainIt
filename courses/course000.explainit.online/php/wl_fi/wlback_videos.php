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

// Data
	if ($_SESSION['loggedin'] == 1)//user came from authentication
	{
			
		$_SESSION["example"] = 1;
		$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>אישור המייל עבר בהצלחה.<br>מיד תועבר לדף התשלום</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא\"ל</h4>";	
		
		if ($_SESSION['paid'] == 'N')// USER NEEDS TO PAY
		{
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>מיד תועבר לדף התשלום</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא\"ל</h4>";	
			//*echo '<script>setTimeout(function(){alert("הי, מיד תועבר לדף התשלום.")}, 2000);</script>';
			//*echo '<script>setTimeout(function(){alert("חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא\"ל.")}, 3000);</script>';
			echo '<script>setTimeout(function(){$("#d").click();}, 4000);</script>';
		}
		
		else
		{		
			$_SESSION['message_1']="<h1 style='margin-bottom:0px;'>התחברות מוצלחת</h1><div style='width:50%;margin:auto;'><hr></div><h4 id='c' style='margin:2px auto;'>את/ה מועבר/ת לאתר</h4>";	
			echo '<script>setTimeout(function(){document.getElementById("F_link").click();}, 2000);</script>';
			//*echo '<script>setTimeout(function(){alert("את/ה מועבר/ת לאתר")}, 3000);</script>';
		}	
	}
	else
	{
		//OUTPUT
		header ("location: ../error_fi/error_videos.php");
	}
	
?>
<head>
<!-- Encoding -->
	<meta charset="utf-8">
	
	<!-- OUTPUT -->
	<!-- favicon -->
	<link rel="icon" type="image/png" href="../../css/favicon.ico">
	
	<!-- OUTPUT -->
	<!-- APPLE TOUCH ICON -->
	<link rel="apple-touch-icon" sizes="57x57" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../../css/favicon.png" />
	
	
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT -->
	<link rel="stylesheet" href="../../css/2.css">
	<!-- General stuff -->
		<!-- Jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>

<body>
<div class="content" style="direction:rtl;text-align:center;">
	
<div id="d" style="float:left;width:100%;padding:5px;text-align:center;">
	<?=$_SESSION['message_1'] ?>
	
	<!-- OUTPUT -->
	<a id="F_link" href="../../logged_in/s10_videos.php"></a>
</div>
<script>
$("#d").click(function(){
	//OUTPUT
	window.location.replace("https://direct.tranzila.com/ttxexplainit/");
});
</script>
</body>