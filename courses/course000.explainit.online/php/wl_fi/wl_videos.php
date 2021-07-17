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
	
	<!-- OUTPUT -->
	<!-- CSS -->
	<link rel="stylesheet" href="../../css/2.css">
	<!-- General stuff -->
		<!-- Jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>

<body>
<div class="content" style="direction:rtl;text-align:center;">
	<h1 style="margin:0px auto;">החשבון הופעל בהצלחה</h1>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<div class="user">
		<h4 id="c" style="margin:0px auto;">מיד תועבר/י לדף התחברות.</h4> 
	</div>
</div>

<div style="float:left;width:100%;padding:5px;text-align:center;">

<?php
		
	// Data
	if ($_SESSION['wl'] == 1)//user came from authentication
	{
		
		$_SESSION['wl'] = 0;
		
		//*echo '<script>setTimeout(function(){alert("הי, מיד תועבר לדף התחברות.")}, 3000);</script>';
		echo '<script>setTimeout(function(){$("#c").click();}, 4000);</script>';
		
	}
	else
	{
		//OUTPUT
		header ("location: ../error_fi/error_videos.php");
	}
?>		
</div>

<script>
$("#c").click(function(){
	//OUTPUT
	window.location.replace("../../login/example_cleveland_l_videos.php");
});
</script>
</body>