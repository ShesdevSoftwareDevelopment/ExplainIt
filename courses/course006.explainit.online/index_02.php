<?php
// SESSION START
	session_start();

// ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

// HTTPS REDIRECT
	if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") 
	{
		$location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: ' . $location);
		exit;
	}

// VARS
	$_SESSION['count'] = 0;
	$_SESSION['wl'] = 0;
	$_SESSION['v_wait'] = 0;
	$_SESSION['loggedin'] = 0;
	$_SESSION['visit_data'] = 1;
	
?>

<!DOCTYPE html>
<html lang="iw" dir="rtl">
<head>
	<!-- GOOGLE ANALYTICS --><!-- OUTPUT 00 -->
		
	<!-- ENCODING -->
	<meta charset="utf-8">
		
	<!-- FAVICON --><!-- OUTPUT 01 -->
	<link rel="icon" type="image/png" href="css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 02 -->
	<link rel="apple-touch-icon" sizes="57x57" href="css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="css/favicon.png" />
	
	<!-- EMOJI CSS --><!-- OUTPUT 03 -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- TITLE -->
	<title>Explainit Online - קורס 006</title>
	
	<!-- DESCRIPTION -->
	<meta name="description" content='פיזיקה לבגרות יא - מכניקה. עם הקורס הזה תוכל/י ללמוד את החומר של כל השנה ב-5 שעות, 3 דקות ו-3 שניות.'>
		
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Assistant&display=swap" rel="stylesheet">
	
	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
			
	<!-- STYLING -->
	<style>
	*
	{
		text-align:center;
		margin:auto;
	}
	
	body
	{
		width:100%;
		position:relative;
		/* font-family:Secular One, Sans Serif; */
		font-family:Assistant, Sans Serif;
		box-sizing:border-box;
		max-width: 960px;
		margin: 0 auto;
		padding: 0px;
	}
	
	a
	{
		text-decoration:none;
		
		color:inherit;
	}
	
	/* SECTIONS */
	.section-1 
	{
		/* height: 865px; */
		/* width: 1925px; */
	}
	
	.section-2 
	{
		/* height: 652px; */
		/* width: 520px; */
		background-color: #ffffff;
	}
	
	.section-3 
	{
		height: 824px;
		width: 2020px;
	}
	
	.section-4 
	{
		height: 836px;
		width: 235px;
	}
	
	.footer 
	{
		height: 127px;
		width: 1981px;
	}
	
	.section-5 
	{
		height: 874px;
		width: 1925px;
	}
	
	.layer-1 
	{
		height: 1334px;
		width: 750px;
	}
	
	/* SECTIONS_ */
	
	/* SECTION 01 */
	
	/* התחברות */
	.text-0
	{
				
		text-align: center;
		
		font-size: 16px; 
		
	}
	
	.rounded-rectangle-1 
	{
		border: 2px solid #E6E6E6;
		
		background-color: #296457;
		
		padding:2px;
		padding-top:0px;
		
		width:20%;
		
		border-radius:5px;
		
		float:left;
		
		margin-left:6px;
		margin-top:6px;
		
		overflow:hidden;
		
		color: #FFFFFF;
		
	}
	
	.rounded-rectangle-1-desktop 
	{
		/* height: 60px; */
		/* width: 147px; */
		
		border: 2px solid #E6E6E6;
		
		background-color: #296457;
		
		padding:2px;
		padding-top:0px;
		
		width:10%;
		
		border-radius:5px;
		
		float:left;
		
		margin-left:6px;
		margin-top:6px;
		
		overflow:hidden;
		
		color: #FFFFFF;
		
	}
	
	.rounded-rectangle-1:hover
	{
		color: black;
	}
	
	.mainimage-png 
	{
		/* height: 220px; */
		/* width: 685px; */
		
		width:90%;
		margin-top:24px;
	}
	
	.rectangle-2 
	{
		/* height: 865px; */
		/* width: 1925px; */
		
		background-color: #EBEBEB;
		
		background: linear-gradient(270deg, #296456 0%, #296457 100%);
		
		padding-bottom:8px;
	}
	/* SECTION 01_ */
	
	/* SECTION 02 */
	.text-2-1
	{
		color:#000000;
		
		font-weight: bold;
		
		margin-top:12px;
		margin-bottom:8px;
		
	}
	
	.text-2-1>h2,
	.text-2-1-desktop>h2
	{
		font-weight: bold;
	}
	
	.text-2-1-desktop
	{
		color:#000000;
		
		font-weight: bold;
		
		margin-top:12px;
		margin-bottom:8px;
		
		font-size:22px;
		
	}
	
	/* Time-Icon */
	.time-icon
	{
		margin-top:24px;
		margin-bottom:8px;
		
		width:60px;
	}
	
	.text-2-2
	{
		color:#000000;
		
		font-weight: 800;
		
		margin:12px auto;
				
		width:75%;
		
		font-size:12px;
		
	}
	
	.text-2-2-desktop
	{
		color:#000000;
		
		font-weight: bold;
		
		margin:0px auto 12px;
				
		width:75%;
		
		font-size:14px;
		
	}
	
	.text-2-3
	{
		color:#000000;
		
		font-weight: 100;
		
		width:75%;
		
		margin:2px auto;
		
		font-size:10px;
	}
	
	.text-2-3-desktop
	{
		color:#000000;
		
		font-weight: 100;
		
		width:75%;
		
		margin:2px auto;
		
		font-size:10px;
	}
	
	.text-2-4
	{
		color:#000000;
		
		font-weight: bold;
		
		width:75%;
		
		margin:16px auto;
		
		font-size:10px;
	}
	
	/* SECTION 02_ */
	
	/* DIV BLUE */
	#div-blue
	{
		background-image: url("04_02.png");
	}
	/* DIV BLUE_ */
	
	/* BUTTON */
	/*http://jeromejaglale.com/doc/css/pretty_button*/	
	
	button 
	{
		padding:6px;
		font-family:Assistant, Sans Serif;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		display: inline-block;
		color: black;
		font-weight: bold;
		padding: 5px 10px 5px;
		white-space: normal;
		text-decoration: none;
		cursor: pointer;
		background: #fab018 url(css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */
		border-style: none;
		text-align: center;
		overflow: visible;
	}
	
	button:hover
	{
		background-color: #2a6456;/*ADDED*/
		background:#2a6456 url(css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */;
		color: white;
		outline:0;/*ADDED*/
	}
	
	.button-div:hover
	{
		background-color: #f9af20;/*ADDED*/
		background:#f9af20 url(css/button_overlay_2.png) repeat-x scroll 0 0;/* OUTPUT 04 */;
		color: black;
		outline:0;/*ADDED*/
	}
	
	button:active 
	{
		background-position: 0 -100px;
		-webkit-box-shadow: none;
	}
	
	
	/* BUTTON_ */
	
	/* LOADER */
	.loader 
	{
		//position:absolute;
		//left:40%;
		//top:40vh;
		margin:auto;
		margin-top:100px;
		border: 16px solid #f3f3f3;
		border-radius: 50%;
		border-top: 16px solid #3498db;
		width: 120px;
		height: 120px;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}
		
	@-webkit-keyframes spin 
	{
		0% { -webkit-transform: rotate(0deg); }
		100% { -webkit-transform: rotate(360deg); }
	}
		
	@keyframes spin 
	{
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
		
	/* LOADER_ */
	
	/* DESKTOP MOBILE */
		
	.buy-button
	{
		width:15%;
	
		margin:auto;
		
		font-size:10px;
	}
	
	.buy-button-special
	{
		margin:auto;
		
		font-size:8px;
		
	}
	
	.special-div
	{
		position:absolute;
		top:54%;
		left:35%;
		width:15%;
		height:10%;
		text-align:right;
	}
	
	.in-special-div
	{
		text-align:right;
	}
	
	.mobile
	{
		display:none;
	}
	
	.column-03
	{
		width:33.33%;
		
		float:right;
	}
	
	@media only screen and (max-width: 600px)
	{
		.mobile
		{
			display:block;
		}
		
		.desktop
		{
			display:none;
		}
		
		.buy-button
		{
			width:30%;
		
			margin:auto;
			
			font-size:14px;
		}
		
		.buy-button-special
		{
			width:100%;
	
			margin:auto;
			
			font-size:12px;
		
		}
		
		.special-div
		{
			position:absolute;
			top:57%;
			left:25%;
			width:25%;
			height:10%;
			text-align:center;
		}
		
		.in-special-div
		{
			text-align:center;
		}
	}
	
</style>	

<!-- Hotjar Tracking Code for www.course005.explainit.online -->
<script>
	(function(h,o,t,j,a,r){
		h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
		h._hjSettings={hjid:1280234,hjsv:6};
		a=o.getElementsByTagName('head')[0];
		r=o.createElement('script');r.async=1;
		r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
		a.appendChild(r);
	})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
</head>

<body style="width:100%;position:relative;">

	<!-- LOADER -->
	<div class="loader"></div>
	
	<script>
		//LOGGING 
		//console.log("---loader")
			
		//SETTING WIDTH VARIABLE
		var a_11_loader = $(document.body).outerWidth()/2-60;
			
		//DEBUGGING
		//console.log("window width: ",$(window).outerWidth());
		//console.log("width from left: ",a_11);
			
		//setting height variable
			var a_12_loader = $(window).outerHeight()/2-60;
			
		//console.log("window height: ",$(window).outerHeight());
		//console.log("height from top: ",a_12_loader);
		
		//setting height and width
		//*$('.loader').css("left",a_11_loader);
		$('.loader').css("left","35%");
		$('.loader').css("top",a_12_loader);
	</script>
	
	<!-- SECTION 01 -->
	<div class="section-1 rectangle-2">
		
		<!-- LOGIN BUTTON -->
		<div class="rounded-rectangle-1 button-div mobile">
			<a href="login/example_cleveland_l_videos.php">
				<div>
					<h4 class="text-0">התחברות</h4>
				</div>
			</a>	
		</div>
		
		<!-- LOGIN BUTTON -->
		<div class="rounded-rectangle-1-desktop button-div desktop">
			<a href="login/example_cleveland_l_videos.php">
				<div>
					<h4 class="text-0">התחברות</h4>
				</div>
			</a>	
		</div>
		
		<!-- IMAGES -->
		<div class="mobile"><img style="width:100%;" src="04_01_.jpg"/></div>
		<div class="desktop"><img style="width:100%;" src="DESKTOP_01.jpg"/></div>
	</div>	
		
		<!-- IMAGE -->
		<div class="mobile"><img style="width:100%;margin-top:-8px;" src="05_01_01.jpg"/></div>
		<div class="desktop"><img style="width:100%;margin-top:-8px;" src="desktop_02_03.jpg"/></div>
		
		<!-- BUTTON -->
		<div style="width:100%;padding:8px 0px 16px 0px;">
			<a href="login/example_cleveland.php">
				<button class="buy-button">לקניית הקורס</button>
			</a>
		</div>
		
		<!-- IMAGE -->
		<div class="mobile"><img style="width:100%;margin-top:8px;" src="03_01_01.jpg"/></div>
		<div class="desktop" style="float:left;"><img style="width:100%;margin-top:8px;" src="DESKTOP_03.jpg"/></div>
		
		<!-- VIDEO -->
		<div class="container mobile" style="width:100%;">
			<div class="container_01" style="width:100%;float:left;margin-top:-8px;">
				<div style="margin-bottom:12px;">
					<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/335558524?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>
					<script src="https://player.vimeo.com/api/player.js"></script>
				</div>
			</div><!-- CONTAINER_01 -->
		</div>	
		
		<!-- VIDEO -->
		<div class="container desktop" style="width:75%;">
			<div class="container_01" style="width:100%;float:left;margin-top:-8px;">
				<div style="margin-bottom:12px;">
					<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/335558524?title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>
					<script src="https://player.vimeo.com/api/player.js"></script>
				</div>
			</div><!-- CONTAINER_01 -->
		</div>	
		
		<!-- BUTTON -->
		<div id="div-blue" style="width:100%;padding:12px 0px 32px 0px;">
			<a href="login/example_cleveland.php">
				<button class="buy-button">לקניית הקורס</button>
			</a>
		</div>
				
	<!-- SECTION 01_-->
	
	<!-- SECTION 02 -->
	<div class="section-2">
		
		<!-- TEXT -->
		<!--<h2 style="font-weight:bolder;" class="text-2-1 mobile">שעורים בקורס</h2>
		<h2 style="font-weight:bolder;" class="text-2-1-desktop desktop">שעורים בקורס</h2>-->
		
		<div class="mobile"><img style="width:100%;margin-top:-8px;" src="10.jpg"/></div>
		<div class="desktop"><img style="width:100%;margin-top:-8px;" src="10-desktop_02.jpg"/></div>
		
		<!-- HR 
		<div style="width:10%;margin:auto;">
			<hr>
		</div>-->
		
		<!-- TEXT MOBILE -->
		<div class="mobile">
			<div style="width:75%;margin:auto;">	
				<h4 style="margin:-8px auto 6px;" class="text-2-2">חלק א'</h4>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">קינמטיקה | מבוא</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">קינמטיקה | גרפים</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">כוחות</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">כוחות | המשך</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">קינמטיקה | המשך</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3"></h6>
			</div>
		
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h4 class="text-2-2">חלק ב'</h4>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">אנרגיה ועבודה</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">תנע ומתקף | חד מימד</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">תנע ומתקף | דו מימד</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3"></h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3"></h6>
			</div>
			
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h4 class="text-2-2">חלק ג'</h4>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">תנועה מעגלית אפקית</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">תנועה מעגלית אנכית</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">כבידה</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;">	
				<h6 class="text-2-3">תנועה הרמונית</h6>
			</div>
			
			<!-- TEXT -->
			<div style="width:75%;margin:auto;margin-bottom:6px;">	
				<h6 class="text-2-3">&nbsp;</h6>
			</div>
		</div>
		
		<!-- TEXT DESKTOP -->
		<div class="desktop">
			<div class="column-03">
				<div style="width:75%;margin:auto;">	
					<h4 class="text-2-2-desktop">חלק א'</h4>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">קינמטיקה | מבוא</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">קינמטיקה | גרפים</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">כוחות</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">כוחות | המשך</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">קינמטיקה | המשך</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop"></h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;margin-bottom:6px;">	
					<h6 class="text-2-3-desktop">&nbsp;</h6>
				</div>
			</div>
			
			<div class="column-03">
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h4 class="text-2-2-desktop">חלק ב'</h4>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">אנרגיה ועבודה</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">תנע ומתקף | חד מימד</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">תנע ומתקף | דו מימד</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop"></h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop"></h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;margin-bottom:6px;">	
					<h6 class="text-2-3-desktop">&nbsp;</h6>
				</div>
			</div>
			
			<div class="column-03">
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h4 class="text-2-2-desktop">חלק ג'</h4>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">תנועה מעגלית אפקית</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">תנועה מעגלית אנכית</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">כבידה</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;">	
					<h6 class="text-2-3-desktop">תנועה הרמונית</h6>
				</div>
				
				<!-- TEXT -->
				<div style="width:75%;margin:auto;margin-bottom:6px;">	
					<h6 class="text-2-3-desktop">&nbsp;</h6>
				</div>
			</div>	
		</div>
	</div>
	<!-- SECTION 02_-->
	
	<!-- IMAGE -->
	<div class="mobile" style="position:relative">
		<img style="width:100%;" src="07_04_01_02.jpg"/>
		
		<div class="special-div">
			<!-- BUTTON -->
			<div class="in-special-div" style="width:100%;">
				<a href="login/example_cleveland.php">
					<button class="buy-button-special">לקניית הקורס</button>
				</a>
			</div>
		</div>
	</div>
	
	<div class="desktop" style="position:relative;float:right;">
		<img style="width:100%;" src="desktop_04_04.jpg"/>
		
		<div class="special-div">
			<!-- BUTTON -->
			<div class="in-special-div" style="width:100%;">
				<a href="login/example_cleveland.php">
					<button class="buy-button-special">לקניית הקורס</button>
				</a>
			</div>
		</div>
	</div>
	<!-- SECTION 02_ -->
	
	<!-- SECTION 03 -->
	<div class="section-2">
		<table style="width:100%;text-align:center;">
			<tr>
				<td style="width:33.33%;padding:16px auto;">
					<a href="terms/Terms of Service 04.04.19.pdf">
						<h6 class="text-2-4">תנאי שימוש</h6>
					</a>
				</td>
				<td style="width:33.33%;padding:16px auto;">
					<a href="terms/Privacy_Statement_02.08.18.pdf">
						<h6 class="text-2-4">מדיניות פרטיות</h6>
					</a>
				</td>
				<td style="width:33.33%;padding:16px auto;">
					<a href="contact/contact.php">
						<h6 class="text-2-4">צור קשר</h6>
					</a>
				</td>
			</tr>
		</table>
	</div>	
	<!-- SECTION 03_ -->
	
	<script>
	<!-- a_11_f script -->
	// loader window resize function
	function a_11_f()
	{
		//console.log("---a 11 f")
		
		var a_11_loader = $(document.body).outerWidth()/2-60;
		//console.log(a_11_loader);
		var a_12_loader = $(window).outerHeight()/2-60;
		//*$('.loader').css("left",a_11_loader);
		$('.loader').css("left","40%");
		$('.loader').css("top",a_12_loader);
	}
	
	<!-- DOCUMENT READY SCRIPT -->
	$(document).ready(function()
	{
		
		//opacity for loader
		$('#div_header_3, #div_table_drills, #hr_number_1, #footer_1, .a1_b1_index,#middle_content').animate({opacity:1},1000);
		$('.loader').css("display","none");
	});
	
	<!-- window resize script -->
	$( window ).resize(function() 
	{
		//loader
		a_11_f();
	});
	</script>
	</body>
</html>