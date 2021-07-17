<?php
session_start();

// display errors
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

// https only
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}
	
// FUNCTIONS
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
		$_SESSION['y_not']=$e[6];
		$_SESSION['y_not_IP']=$_SERVER['REMOTE_ADDR'];
		return $e;
}
	
// IF	
	if($_SESSION['loggedin'] == 1)
{
		// Vars
		$_SESSION['count'] = 0;
		$_SESSION['wl'] = 0;
		$_SESSION['v_wait'] = 0;
				
		//FUNCS
		$v=set_num($_SESSION['timestamp']);//check no.6
	?>

	<!DOCTYPE html>
	<html lang="iw" dir="rtl">
	<head>

	<!-- Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-67294456-1"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		
		gtag('config', 'UA-67294456-1');
		</script>

	<!-- Document Links -->
		<!-- OUTPUT -->
		<!-- favicon -->
		<link rel="icon" type="image/png" href="../css/favicon.ico">
		
		<!-- OUTPUT -->
		<!-- APPLE TOUCH ICON -->
		<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
		<!-- Encoding -->
		<meta charset="utf-8">
		<!-- Viewport -->
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- Links -->
			<!-- Styling-->
			<style>
			/* BUTTON *//*http://jeromejaglale.com/doc/css/pretty_button*/	
			.button 
			{
				/*font: bold 13px "Helvetica Neue", Helvetica, Arial, clean, sans-serif !important;*/
				/*text-shadow: 0 -1px 1px rgba(0,0,0,0.25), -2px 0 1px rgba(0,0,0,0.25);*/
				border-radius: 5px;
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
				/*-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.5);*/
				/*-webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.5);*/
				display: inline-block;
				color: white;
				padding: 5px 10px 5px;
				/*white-space: nowrap;*//*CHANGED*/
				white-space: normal;
				text-decoration: none;
				cursor: pointer;
				background: #A9014B;
				border-style: none;
				text-align: center;
				overflow: visible;
			}
			
			.button:hover
			/*,.button:focus*//*REMOVED*/
			{
				background-color: #1ebbd7;/*ADDED*/
				outline:0;/*ADDED*/
				/*background-position: 0 -50px;*/
				/*color: white;*/
			}
			
			.button:active 
			{
				background-position: 0 -100px;
				/*-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.7);*/
				-webkit-box-shadow: none;
			}
			
				/* General stuff 2.css */
				
				section, footer, nav {
				display: block;
				}
				
				body {
				font-family: 'Varela Round', sans-serif;
				-webkit-text-size-adjust: none;
				color: #333;
				max-width: 720px;
				margin: 0 auto;
				padding: 10px;
				}
				
				input
				{
				font-family: 'Varela Round', sans-serif;
				}
				
				a {
				color: blue;
				color: hsl( 220, 90%, 40% );
				text-decoration: none;
				}
				
				a:hover {
				/*background-color: blue;*/
				/*background-color: hsl( 220, 90%, 50% );*/
				color: purple;
				}
				
				#options {
				position: relative;
				z-index: 100;
				margin-bottom: 40px;
				}
				
								
				footer {
				/*border-top: 1px solid #CCC;*/
				font-size: 0.8em;
				position: relative;
				z-index: 100;
				}
				
				#disclaimer {
				color: red;
				font-weight: bold;
				display: none;
				}
				.no-csstransforms3d #disclaimer { display: block; }
				
				hr {
				border: none;
				border-top: 1px solid #CCC;
				}
				
				figure {
				margin: 0;
				}
				
				code {
				font-family: 'Monaco', 'Menlo', monospace;
				}
				
				/*---------------*/
					* 
					{
						font-family: 'Varela Round', sans-serif;
						box-sizing:border-box;
					}
							
					#div_upper 
					{
						width:100%;
						background-color:green;
						color:white;
					}
						
					#div_event 
					{	
						width:100%;
						background-color:purple;
					}
					
					#div_trail
					{
						float:right;
						/*height:20%;*/
						/*overflow-x:scroll;*/
					}
					
					#station_table
					{
						border-collapse:collapse;
					}
									
					#station_table td
					{
						border:0.5px solid black;
						border-collapse:collapse;
					}
					
					#station_result,
					#station_result_1_1
					{
						margin-right:6px;
						margin-top:9px;
					}
					
					#station_result>b 
					{
						font-size:16px;
					}
					
					#station_header,
					#station_header_2
					{
						width:100%;
					}
						
					#station_header>b 
					{
						font-size:16px;
					}
					
					#station_header_2>b 
					{
						font-size:16px;
					}
					
					#station_result_1_1>b 
					{
						font-size:16px;
					}
					
					#station_result,
					#station_result_1_1,
					#station_result_home
					
					{
						/*
						display:inline-block;
						margin-top:3px;
						margin-bottom:3px;
						*/
						float:right;
						height:100%;
					}
					
					#station_result_home,
					#station_result_home_2,
					#station_result_home_3,
					
					#div_story
					{
						display:inline-block;
						text-align:center;
						font-size:16px;
						border:1px black solid;
						padding:2px 4px;
						vertical-align:top;
						margin-top:3px;
						margin-bottom:3px;
					}
					
					#station_result_home
					{
						margin:6px auto;
					}
					
					#div_story
					{
						display:block;
						text-align:initial;
					}
					
					#station_result,
					#station_result_1_1
					{
						border-radius:13px 0px 13px 13px;
						border:dashed;
						padding:14px 6px;
					}
					
					#station_result_home
					{
						border-radius:14px;
						border:solid;
						margin-right:6px;
						padding:14px 6px;
					}
					
					a,li
					{
				
						/* These are technically the same, but use both */
						overflow-wrap: break-word;
						word-wrap: break-word;
				
						-ms-word-break: break-all;
						/* This is the dangerous one in WebKit, as it breaks things wherever */
						word-break: break-all;
						/* Instead use this non-standard one: */
						word-break: break-word;
				
						/* Adds a hyphen where the word breaks, if supported (No Blink) */
						-ms-hyphens: auto;
						-moz-hyphens: auto;
						-webkit-hyphens: auto;
						hyphens: auto;
				
						}
						
						
						* {font-size:16px;}
						
						div[contenteditable]
						{
							border: 1px solid black;
							max-height: 200px;
							overflow: auto;
						}
						
							@media only screen and (max-width: 500px)
							{
								
								.responsive 
								{
								width: 100%;
								}
								
								.dropdown-content_co 
								{
								top: -4px;
								}
								
								/*checking something*/
								#station_result,
								#station_result_1_1,
								#station_result_home,
								#station_result_home_2,
								#station_result_home_3,
								#station_header,
								#station_header_2
								{
									width:100%;
									margin-top:3px;
									margin-bottom:3px;
									text-align:center;
								}
								
								#div_trail
								{
									height:initial;
									overflow-y:scroll;
									overflow-x:hidden;
								}
							}
							
							.clearfix:after 
							{
								content: "";
								display: table;
								clear: both;
							}
							
										
						/*Tables and other stuff from 2.php*/	
								
							#div_header_2 
							{
								width:100%;
								background-color:blue;
							}
							
							#div_table_names 
							{
								width:100%;
								margin:auto;
							}
							
							#div_table_drills 
							{
								width:100%;
								margin:auto;
							}
								
							#table_names 
							{	
								width:100%;
								margin:auto;
								border:1px solid black;
								text-align:center;
								border-collapse:collapse;
							}
							
							#table_names th 
							{
								border:1px solid black;
								border-collapse:collapse;
							}
								
							.table_drills 
							{
								width:100%;
								margin:auto;
								/*border:1px solid black;*/
								text-align:center;
								border-collapse:collapse;
							}
							
							.table_drills th 
							{
								border:1px solid black;
								border-collapse:collapse;
							}
							
							.table_drills td 
							{
								border:1px black solid;
								/*border-right-style:ridge;*/
							}
							
							//SUBSUBJECT TABLE
							.subsubject_table 
							{
								width:100%;
								margin:auto;
								/*border:1px solid black;*/
								text-align:center;
								border-collapse:collapse;
							}
							
							.subsubject_table th 
							{
								border:1px solid black;
								border-top:none;
								border-bottom:none;
								border-collapse:collapse;
							}
							
							.subsubject_table td 
							{
								text-align:center;
								border-top:none; 
								
							}
							
							#table_colors td 
							{
								border:none;
							}
							
							hr 
							{
								margin:0.5px;
							}
							
							#hr_1 
							{
								margin:-0.5px;
								height:0.75px;
								background-color:darkgrey;
							}
								
							#hr_2 
							{
								margin:0.5px;
								border-style:solid;
							}
						
							.giraffe,
							.example,
							.car,
							.steel,
							.paper,
							.rock,
							.tree, 
							.water,
							.metal,
							.oil,
							.copper,
							.bronze,
							.silver,
							.gold,
							{
								display:none;
							}
							
							#comments_list a {
								/*display:inline;*/
								margin:0px;
							}
										
							/* w3schools loader */
							
							#div_header_3,
							#div_table_drills,
							#hr_number_1,
							#new_comment,
							#footer_1,
							#a1_index,
							#a1_index_h3,
							.a1_b1_index
							{
								opacity:0;
							}
							
							.loader {
							position:absolute;
							//left:40%;
							//top:40vh;
							border: 16px solid #f3f3f3;
							border-radius: 50%;
							border-top: 16px solid #3498db;
							width: 120px;
							height: 120px;
							-webkit-animation: spin 2s linear infinite;
							animation: spin 2s linear infinite;
							}
				
							@-webkit-keyframes spin {
							0% { -webkit-transform: rotate(0deg); }
							100% { -webkit-transform: rotate(360deg); }
							}
				
							@keyframes spin {
							0% { transform: rotate(0deg); }
							100% { transform: rotate(360deg); }
							}
							
				
				body {
				-webkit-text-size-adjust: none;
				color: #333;
				margin: 0 auto;
				padding: 10px;
				}
				
				* {
					box-sizing: border-box;
				}
				
				input 
				{
					border-radius:0px;
				}
				
				#status_div_1
				{
					background-color:green;
				}
				
				#subject_a1_b1,#subject_a1_b2
				{
					cursor:pointer;
				}
			
			/* GENERAL */
						
			.station_1
			{
				display:none;
			}
				
			.station
			{
				margin: auto;
				text-align: center;
				opacity: 1;
				float: right;
				border: 1px black solid;
				border-radius: 5px;
				padding: 0px 5px;
				margin-top: 5px;
			}
			
			/*no_top_border*/
			#a1_b2,
			#a1_b2_main
			{
				border-top:0px;
			}
			
			.can_be_clicked
			{
				background-color:#A9014B;
			}
			
			.hidden
			{
				display:none;
			}
			
			.clicked
			{
				background-color:#1ebbd7;
			}
			
			.unclicked
			{
				background-color:#a9014b;
			}
			
			.td_click
			{
				display:none;
			}
			
			.subject_td:hover,
			.subject_td:focus 
			{
				background-color: #1ebbd7;/*ADDED*/
				outline:0;/*ADDED*/
			}
			
			.subject_td:active 
			{
				background-position: 0 -100px;
				-webkit-box-shadow: none;
			}
			
			@media only screen and (max-width: 500px)
			{
				#table_colors td 
				{
					padding:0px 2px;
				}
				
				.in_table_td 
				{
					padding:0px 2px;
				}
			}	
			</style>
			<!-- Font Awesome -->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<!-- Emoji CSS -->
			<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<!-- Jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Scripts -->	
		
		
		<!-- ajax_checked script -->
		<!-- get_check_marks_of_group script -->
		
	</head>

	<body style="width:100%;position:relative;">

		<!-- Include loader.php -->		
			<!-- Loader -->
			<div class="loader"></div>
		
		
			<!-- loader script - loader.js-->
			<script>
			//logging initiation
			console.log("---loader")
				
			//setting width variable
				var a_11_loader = $(window).outerWidth()/2-60;
				
				//debugging
					//console.log("window width: ",$(window).outerWidth());
					//console.log("width from left: ",a_11);
				
			//setting height variable
				var a_12_loader = $(window).outerHeight()/2-60;
				
				//console.log("window height: ",$(window).outerHeight());
				//console.log("height from top: ",a_12_loader);
			
			//setting height and width
				$('.loader').css("left",a_11_loader);
				$('.loader').css("top",a_12_loader);
		</script>		

	<!-- Commercials -->	
		<!--
			<div class="commercial" style="position:absolute;right:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:220px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:430px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:640px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;right:-206px;top:850px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			
			<div class="commercial" style="position:absolute;left:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"><img src="pics/saved.png" style="width:100%;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:220px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:430px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:640px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
			<div class="commercial" style="position:absolute;left:-206px;top:850px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		-->
			
	<!-- Middle Content -->	
		<div id="middle_content" style="float:right;right:0px;float:right;width:100%;;max-width:720px;">
						
			<!-- subjects module -->
			
			<!-- top buttons menu -->
			<div style="float:right;">
				<!-- OUTPUT -->
				<a href="logout.php"><div id="logout_div" style="margin:2px 2px 1px 0px;padding:0px 2px;border:1px black solid;float:right;">התנתק/י</div></a>
			</div>
			
			<div style="float:right;">
				<div id="status_div_1" style="margin:2px 2px 1px 0px;padding:0px 2px;border:1px black solid;float:right;color:white;">מחובר/ת</div>
			</div>
				
			<div id="div_header_3" style="float:right;text-align:center;font-size:24px;position:relative;top:0px;width:100%;">
			<!-- HEADER -->
			<h1 id="page_h1" style="margin-bottom:0px 0px 0px 0px;font-size:24px;">סרטונים לפי נושא</h1>						
			
			<!-- HR -->
			<div style="width:50%;margin:auto;">
				<hr>
			</div>
			
			<!-- SELECT SUBJECT -->
			<div id="div_table_drills" style="width:100%;margin:auto;text-align:center;float:right;">
				<h3 style="font-size:16px;">בחר/י נושא ראשי מהרשימה.</h3>
			</div>
			
			<div style="width:100%;float:right;">
				<table id="table_colors" style="margin-bottom:2px;width:100%;border-collapse:collapse;text-align:center;">
					<tr>
						<td>
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1" class="responsive_input_4 button" style="width:100%;">מכניקה</button>
							</div>
						</td>
												
						<td style="width:50%;">
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a2" class="responsive_input_4 button" style="width:100%;">אלקטרומגנטיות</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a3" class="responsive_input_4 button" style="width:100%;">קרינה וחומר</button>
							</div>
						</td>
											
						<td style="width:50%;">
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a4" class="responsive_input_4 button" style="width:100%;">פיתרון בגרויות</button>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<div id="a1_index" style="float:right;width:100%;">
			<!-- HR -->
			<div style="width:50%;margin:auto;">
				<hr>
			</div>
			
			<!-- SELECT SUBJECT -->
			<div id="a1_index_h3" style="width:100%;margin:auto;text-align:center;">
				<h3 style="font-size:16px;">בחר/י נושא משני מהרשימה.</h3>
			</div>
			
			<div style="width:100%;">
				<table id="table_colors" style="margin-bottom:2px;width:100%;border-collapse:collapse;text-align:center;">
					<tr>
						<td>
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b1_index" class="responsive_input_4 button" style="width:100%;">קינמטיקה</button>
							</div>
						</td>
												
						<td style="width:50%;">
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b2_index" class="responsive_input_4 button" style="width:100%;">דינמיקה</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b3_index" class="responsive_input_4 button" style="width:100%;">אנרגיה</button>
							</div>
						</td>
											
						<td style="width:50%;">
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b4_index" class="responsive_input_4 button" style="width:100%;">תנע</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b5_index" class="responsive_input_4 button" style="width:100%;">מעגלית אפקית</button>
							</div>
						</td>
											
						<td style="width:50%;">
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b6_index" class="responsive_input_4 button" style="width:100%;">הרמונית</button>
							</div>
						</td>
					</tr>
					<tr>
						<td>
						<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b7_index" class="responsive_input_4 button" style="width:100%;">מעגלית אנכית</button>
							</div>
						</td>
											
						<td style="width:50%;">
							<!-- BUTTON -->
							<div style="width:100%;margin:auto;">
								<button id="a1_b8_index" class="responsive_input_4 button" style="width:100%;">כבידה</button>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
				
		<div class="a1_b1_index" style="float:right;width:100%;">	
			<!-- HR -->
			<div style="width:50%;margin:auto;">
				<hr>
			</div>
			
			<!-- SELECT SUBJECT -->
			<div style="width:100%;margin:auto;text-align:center;float:right;">
				<h3 style="font-size:16px;">בחר/י נושא מהרשימה.</h3>
			</div>
		</div>
		
		<div id="div_table_drills_2" style="width:100%;margin:auto;float:right;"></div>
					
	<!-- Footer -->    
		<footer id="footer_1" style="float:right;clear:both;">

		<br>
		<!-- License Data -->	
<!--				<div style="float:right;clear:both;/*background-color:green;*/">
					<div id="under_comments_2" class="dropbtn_2" style="display:inline-block;">רישיון</div>
					<p style="margin-top:0px;">אתר זה מתנהל לפי רישיון מסוג: <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"></a><a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">&nbsp;<img alt="Creative Commons License" style="border-width:0;vertical-align:text-top;" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a></p>
					<p style="margin-top:0px;">מאובטח על ידי: &nbsp;<img alt="Condo SSL" style="border-width:0;vertical-align:text-top;" src="../../ssl/comodo_secure_seal_76x26_transp.png"/></p>
				</div>
				
				<div id="confirmBox">
					<div class="message"></div>
					<span class="yes">Yes</span>
					<span class="no">No</span>
				</div>
-->				
			</footer>
		</div>

		<!-- Funcs -->
		<script>
		<!-- cl script cl.js -->
		function cl(str,variable)
		{
			console.log(str,variable);
		}
			
		<!-- a_11_f script -->
		// loader window resize function
		function a_11_f()
		{
			console.log("---a 11 f")
			
			var a_11_loader = $(document).outerWidth()/2-60;
			//console.log(a_11_loader);
			var a_12_loader = $(window).outerHeight()/2-60;
			$('.loader').css("left",a_11_loader);
			$('.loader').css("top",a_12_loader);
		}
		
		<!-- CHECK CLASS -->
		function check_class(id)
		{
			
			var classList = document.getElementById(id).className.split(/\s+/);
			var counter = 0;
			
			for (var i = 0; i < classList.length; i++)
			{
				if (classList[i] == 'clicked') 
				{
					$('#'+id).addClass('unclicked');
					$('#'+id).removeClass('clicked');
					
					break;
				}
				else
				{
					counter++;
				}
			}
			
			if( counter == classList.length)
			{
				$('#'+id).addClass('clicked');
				$('#'+id).removeClass('unclicked');
			}
		}
				
		<!-- document ready script -->
		$(document).ready(function()
		{
			
		//clickability	
			$("#a1").click(function()
			{
				//TOGGLE INDEX
				$("#a1_index").toggle();
				
				//TOGGLE DISPLAY
				$(".a1_b1_index").toggle(false);
				$("#div_table_drills_2").toggle(false);
				
				//TOGGLE DISPLAY
				$("#a1_b1_index").removeClass("clicked");
								
				//FUNCTION
				check_class(this.id);
			});
			
			$("#a1_b1_index").click(function()
			{
				//FUNCTION
				check_class(this.id);
								
				//OUTPUT
				//POST REQUEST
				$.post("metal_2_videos.php",
					{
					string_1:"<?= $_SERVER['REMOTE_ADDR']?>",
					number_1:"12"	,
					v_0:"<?= $v[0]; ?>",
					v_1:"<?= $v[1]; ?>",
					v_2:"<?= $v[2]; ?>",
					v_3:"<?= $v[3]; ?>",
					v_4:"<?= $v[4]; ?>",
					v_5:"<?= $v[5]; ?>",
					v_6:"<?= $v[6]; ?>",
					v_7:"<?= $v[7]; ?>",
					v_8:"<?= $v[8]; ?>",
					v_9:"<?= $v[9]; ?>",
					},
					function(data, status, example_var)
					{
												
						//GETTING HTML
						$("#div_table_drills_2").html(data);//CHANGED
						
						//HIDING DIV
						$("#a1_b1_c1_index").css('opacity','0');
						
						//OUTPUT
						//GETTING VIEWS
						//GETTING CURRENT VIEWS STATUS//ALL
						$.post("metal_6_g_videos.php",
						{
							subject_1:"all",
							question_1:"all",
						},
						function(data, status)
						{
							var result_views = JSON.parse(data);
							console.log("views:",result_views['Q1']);
							$("#a1_b1_c1_views").html("("+result_views['Q1']+" "+"צפיות"+")").promise().done(function(){
								//SHOWING DIV
								$("#a1_b1_c1_index").animate({opacity:1},1000);
							});
						});;
						
						//CLICK
						$("#td_click").click(function()
						{
							$(".td_click").toggle();
						});
												
						$("#a1_b1").click(function()
						{
							//HIDE OTHER TOP LINES
							$("#a1_b2_top_line").toggle(false);
							$("#a1_b2_c1_top_line").toggle(false);
							
							//SHOW TOP LINES
							$("#a1_b1_top_line").toggle();
							$("#a1_b1_c1_top_line").toggle();
							$("#a1_b1_c2_top_line_on_top").toggle();
							
							//CLOSE BOTTOM LINES
							$("#a1_b1_c2_top_line_bottom").toggle(false);
							
							//CLOSE TABLES
							$("#a1_b1_c1_table").toggle(false);							
							$("#a1_b1_c2_table").toggle(false);							
							$("#a1_b2_c1_table").toggle(false);							
								
							//TABLE OPACITY
							$(".a1_b2_table").css("opacity","0.5");
							$(".a1_b1_table").css("opacity","1");
						});
						
						
						//TOGGLE DISPLAY
						setTimeout(function(){ $("#a1_b1").click(); }, 500);
						
						//TOGGLE DISPLAY
						$(".a1_b1_index").toggle();
						$("#div_table_drills_2").toggle();
						
						//GET CURRENT COMMENTS
						//GET CURRENT VIEWS
						//GET CURRENT COLORS
						
						//OUTPUT
						//GETTING CURRENT COMMENTS STATUS//ALL
						$.post("metal_6_h_videos.php",
						{
							subject_1:"all",
							question_1:"all",
						},
						function(data, status)
						{
							var result_1 = JSON.parse(data);
							console.log("comments:",result_1);
				//UPDATE									
							//UPDATING TEXTAREA
							$("#textarea_a1_b1_c1").val(result_1["Q1"]);
							$("#textarea_a1_b1_c2").val(result_1["Q2"]);
							$("#textarea_a1_b2_c1").val(result_1["Q3"]);
						});
						//END OF GETTING COMMENTS STATUS//ALL
												
						//OUTPUT
						//GETTING CURRENT VIEWS STATUS//ALL
						$.post("metal_6_g_videos.php",
						{
							subject_1:"all",
							question_1:"all",
						},
						function(data, status)
						{
							var result_1 = JSON.parse(data);
							console.log("views:",result_1);
				
				//UPDATE									
				
							//CASES
														
							$("#views_a1_b1_c2").html(result_1["Q2"]);
									
							$("#views_a1_b2_c1").html(result_1["Q3"]);
						});
						//END OF GETTING VIEWS STATUS//ALL
						
						//OUTPUT						
						//GETTING CURRENT COLORS STATUS//ALL
						$.post("metal_6_i_videos.php",
						{
							subject_1:"all",
							question_1:"all",
						},
						function(data, status)
						{
							var result_1 = JSON.parse(data);
							console.log("colors:",result_1);
				//UPDATE																				
							//CASES
							//a1_b1_c1
							if(result_1["Q1"] == 0)
							{
								$(".a1_b1_c1_main").css("background-color","white");
							}
							if(result_1["Q1"] == 1)
							{
								$(".a1_b1_c1_main").css("background-color","green");
							}
							if(result_1["Q1"] == 2)
							{
								$(".a1_b1_c1_main").css("background-color","red");
							}
							//a1_b1_c2
							if(result_1["Q2"] == 0)
							{
								$(".a1_b1_c2_main").css("background-color","white");
							}
							if(result_1["Q2"] == 1)
							{
								$(".a1_b1_c2_main").css("background-color","green");
							}
							if(result_1["Q2"] == 2)
							{
								$(".a1_b1_c2_main").css("background-color","red");
							}
							//a1_b2_c1
							if(result_1["Q3"] == 0)
							{
								$(".a1_b2_c1_main").css("background-color","white");
							}
							if(result_1["Q3"] == 1)
							{
								$(".a1_b2_c1_main").css("background-color","green");
							}
							if(result_1["Q3"] == 2)
							{
								$(".a1_b2_c1_main").css("background-color","red");
							}
						});
						//END OF GETTING COLORS STATUS//ALL
				//A1
						//PLAY ICON a1_b1_c1
						
						$(document).on("click touchstart", "#play_icon_a1_b1_c1", function () {
														
							//OUTPUT
							//UPDATING PLAYS NUMBER//SINGLE
							$.post("metal_6_d_videos.php",
							{
								subject_1:"a1",
								question_1:"Q1",
							},
							function(data, status)
							{
								console.log('OK');
							});
							//END OF UPDATING VIEWS POST REQUEST
							
							//CLICKING PLAY
							setTimeout(function(){ $("#input_08_a1_b1_c1").click(); }, 1000);
						});	
												
						//TOGGLE a1_b1_c1	
						
						$("#a1_b1_c1_index").click(function()
						{
							//UPDATING SPANS
							$("#class_number").html("שעור 1");
							$("#subject_1_number").html("מכניקה");
							$("#subject_2_number").html("קינמטיקה");
							
							//TOGGLE TABLE DISPLAY
							$(".station_1").toggle();
							$("#a1_b1_c1_table").toggle();
							
							//CLOSING OTHER OPEN COMMENTS TABLES
							$("#a1_b1_c2_table").toggle(false);
							$("#a1_b2_c1_table").toggle(false);
							
							//SWITCH TOP LINE DISPLAY FROM TOP TO BOTTOM
							$("#a1_b1_c2_top_line_on_top").toggle();
							$("#a1_b1_c2_top_line_bottom").toggle();
							
							//FUNCTION
							check_class(this.id);
						});
						//END OF subject_a1_b1 CLICK
												
										
						//GOT IT/DIDN'T GET IT//A1
						//CHANGE VALUE UPON CLICK
						$("#gotit_a1_b1_c1").click(function()
						{
							//LOCAL COLORS
							$(".a1_b1_c1_main").css("background-color","green");
							$("#a1_b1_c1_main_header").css("color","white");
							$("#dgetit_a1_b1_c1").css("background-color","#a9014b");
							$("#gotit_a1_b1_c1").css("background-color","green");
							
							//a1_b1 BACKGROUND COLORS
							if($(".a1_b1_c2_main").css("background-color") == 'green')
							{
								alert("full set green");
								$(".a1_b1_main").css("background-color","green");
							}
											
							//OUTPUT
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q1",
								value_1:"1",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						}); 
						//END OF gotit_a1 CLICK
						
						$("#dgetit_a1_b1_c1").click(function()
						{
							//LOCAL COLORS
							$(".a1_b1_c1_main").css("background-color","red");
							$("#a1_b1_c1_main_header").css("color","white");
							$("#dgetit_a1_b1_c1").css("background-color","red");
							$("#gotit_a1_b1_c1").css("background-color","#a9014b");
							
							//a1_b1 BACKGROUND COLORS
							if($(".a1_b1_c2_main").css("background-color") == 'red')
							{
								alert("full set green");
								$(".a1_b1_main").css("background-color","red");
							}
														
							//OUTPUT
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q1",
								value_1:"2",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						});
						//END OF dgetit_a1 CLICK
						
						//CLEAR COLORS//A1
						$("#clear_colors_a1_b1_c1").click(function()
						{
							//LOCAL COLORS
							$(".a1_b1_main").css("background-color","#a9014b");
							$(".a1_b1_c1_main").css("background-color","#a9014b");
							$("#a1").css("background-color","#A9014B");
							$("#dgetit_a1_b1_c1").css("background-color","red");
							$("#gotit_a1_b1_c1").css("background-color","#a9014b");
							
							
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q1",
								value_1:"0",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						});
						//END OF clear_colors CLICK
						
						//SAVE//A1
						$("#save_button_a1_b1_c1").click(function()
						{
							//SANITIZING FUNCTIONS
							function escapeRegExp(string)
							{
								//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
								string = string.replace("script", "scipbt"); 
								string = string.replace("'", "`"); 
								return string; 
							}
							
							//COMPARING CURRENT & NEW COMMENTS
							function check_current_comment(result)							
							{
								//VARS
								var current_comment = $("#textarea_a1_b1_c1").val();
								var previous_comment = result;
								
								//CASES
								if (current_comment.length == 0 && previous_comment.length == 0)
								{
									alert("אין מה לעדכן.");
								}
								else if (current_comment.length == 0 && previous_comment.length != 0)
								{
									if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
									{
										if(current_comment.length > 1000)
										{
											alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
										}
										else//UPDATING COMMENT TO NEW COMMENT
										{
											//ESCAPING CHARS
											var text_value = escapeRegExp(current_comment);
											
											//OUTPUT
											//INSERT NEW COMMENT
											$.post("metal_6_videos.php",
											{
												comments_a1: text_value,
												question_1: 'Q1',
											},
											function(data, status)
											{
												alert("ההערה נמחקה בהצלחה.");
											}//END OF POST SUCCESS FUNCTION
											);//END OF POST REQUEST
										}
									}
									else//DOESN'T WANT TO DELETE
									{
										$("#textarea_a1_b1_c1").val(previous_comment);
									}
								}
								else// USUAL COMMENT UPDATE
								{
									if(current_comment.length > 1000)
									{
										alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
									}
									else//UPDATING TO NEW COMMENT
									{
										//ESCAPING CHARS
										var text_value = escapeRegExp(current_comment);
										
										//OUTPUT
										//INSERT NEW COMMENT
										$.post("metal_6_videos.php",
										{
											comments_a1: text_value,
											question_1: 'Q1',
										},
										function(data, status)
										{
											alert("ההערה נשמרה בהצלחה.");
										}//END OF POST SUCCESS FUNCTION
										);//END OF POST REQUEST
									}//UPDATE END
								}//USUAL UPDATE END
							}//FUNCTION END
							
							//OUTPUT
							//GETTING CURRENT COMMENT
							$.ajax
							({
								url: 'metal_6_b_videos.php',
								type: 'POST',
								//data: {'Y_n': data_1_js,
								//		'Number_0': num}
								data: {Y_n: 'Q1'}
							}).done(function(result)
							{
								check_current_comment(result); 
							});
						});
						//END OF SAVE_BUTTON_A1 CLICK
																						
						//CLICK//A1
					
					//a1_b1_c2
						//PLAY ICON a1_b_c2 TOP LINE
						
						$(document).on("click touchstart", "#play_icon_a1_b1_c2_top_line_on_top ", function () {
														
							//OUTPUT
							//UPDATING PLAYS NUMBER//SINGLE
							$.post("metal_6_d_videos.php",
							{
								subject_1:"a1",
								question_1:"Q2",
							},
							function(data, status)
							{
								console.log('OK');
							});
							//END OF UPDATING VIEWS POST REQUEST
							
							//CLICKING PLAY
							setTimeout(function(){ $("#input_08_a1_b1_c2").click(); }, 1000);
						});	
						
						//PLAY ICON a1_b1_c2 BOTTOM LINE
						
						$(document).on("click touchstart", "#play_icon_a1_b1_c2", function () {
														
							//OUTPUT
							//UPDATING PLAYS NUMBER//SINGLE
							$.post("metal_6_d_videos.php",
							{
								subject_1:"a1",
								question_1:"Q2",
							},
							function(data, status)
							{
								console.log('OK');
							});
							//END OF UPDATING VIEWS POST REQUEST
							
							//CLICKING PLAY
							setTimeout(function(){ $("#input_08_a1_b1_c2").click(); }, 1000);
						});	
						
						
						//TOGGLE//A1	
						
						$("#subject_a1_b1_c2").click(function()
						{
							//CLOSE OTHER TABLES
							$("#a1_b1_c1_table").toggle(false);
							$("#a1_b2_c1_table").toggle(false);
							
							//HIDE BOTTOM TABLE
							$("#a1_b1_c2_top_line_bottom").toggle(false);
							
							//SHOW TOP LINE
							$("#a1_b1_c2_top_line_on_top").toggle();
							
							//SHOW TOP TABLE
							$("#a1_b1_c2_table").toggle();
							
						});
						//END OF subject_a1_b1 CLICK
												
										
						//GOT IT/DIDN'T GET IT//A1
						//CHANGE VALUE UPON CLICK
						$("#gotit_a1_b1_c2").click(function()
						{
							//LOCAL COLORS
							$(".a1_b1_c2_main").css("background-color","green");
							
							//a1_b1 BACKGROUND COLORS
							if($(".a1_b1_c1_main").css("background-color") == 'green')
							{
								alert("full set green");
								$(".a1_b1_main").css("background-color","green");
							}
											
							//OUTPUT
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q2",
								value_1:"1",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						}); 
						//END OF gotit_a1 CLICK
						
						$("#dgetit_a1_b1_c2").click(function()
						{
							//LOCAL COLORS
							$(".a1_b1_c2_main").css("background-color","red");
							
							//a1_b1 BACKGROUND COLORS
							if($(".a1_b1_c1_main").css("background-color") == 'red')
							{
								alert("full set red");
								$(".a1_b1_main").css("background-color","red");
							}
							
							//OUTPUT
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q2",
								value_1:"2",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						});
						//END OF dgetit_a1 CLICK
						
						//CLEAR COLORS//A1
						$("#clear_colors_a1_b1_c2").click(function()
						{
							//LOCAL COLORS
							$(".a1_b1_main").css("background-color","white");
							$(".a1_b1_c2_main").css("background-color","white");
							$("#a1").css("background-color","#A9014B");
							
							//OUTPUT
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q2",
								value_1:"0",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						});
						//END OF clear_colors CLICK
						
						//SAVE//A1
						$("#save_button_a1_b1_c2").click(function()
						{
							//SANITIZING FUNCTIONS
							function escapeRegExp(string)
							{
								//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
								string = string.replace("script", "scipbt"); 
								string = string.replace("'", "`"); 
								return string; 
							}
							
							//COMPARING CURRENT & NEW COMMENTS
							function check_current_comment(result)							
							{
								//VARS
								var current_comment = $("#textarea_a1_b1_c2").val();
								var previous_comment = result;
								
								//CASES
								if (current_comment.length == 0 && previous_comment.length == 0)
								{
									alert("אין מה לעדכן.");
								}
								else if (current_comment.length == 0 && previous_comment.length != 0)
								{
									if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
									{
										if(current_comment.length > 1000)
										{
											alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
										}
										else//UPDATING COMMENT TO NEW COMMENT
										{
											//ESCAPING CHARS
											var text_value = escapeRegExp(current_comment);
											
											//OUTPUT
											//INSERT NEW COMMENT
											$.post("metal_6_videos.php",
											{
												comments_a1: text_value,
												question_1: 'Q2',
											},
											function(data, status)
											{
												alert("ההערה נמחקה בהצלחה.");
											}//END OF POST SUCCESS FUNCTION
											);//END OF POST REQUEST
										}
									}
									else//DOESN'T WANT TO DELETE
									{
										$("#textarea_a1_b1_c2").val(previous_comment);
									}
								}
								else// USUAL COMMENT UPDATE
								{
									if(current_comment.length > 1000)
									{
										alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
									}
									else//UPDATING TO NEW COMMENT
									{
										//ESCAPING CHARS
										var text_value = escapeRegExp(current_comment);
										
										//OUTPUT
										//INSERT NEW COMMENT
										$.post("metal_6_videos.php",
										{
											comments_a1: text_value,
											question_1: 'Q2',
										},
										function(data, status)
										{
											alert("ההערה נשמרה בהצלחה.");
										}//END OF POST SUCCESS FUNCTION
										);//END OF POST REQUEST
									}//UPDATE END
								}//USUAL UPDATE END
							}//FUNCTION END
							
							//OUTPUT
							//GETTING CURRENT COMMENT
							$.ajax
							({
								url: 'metal_6_b_videos.php',
								type: 'POST',
								//data: {'Y_n': data_1_js,
								//		'Number_0': num}
								data: {Y_n: 'Q2'}
							}).done(function(result)
							{
								check_current_comment(result); 
							});
						});
						//END OF SAVE_BUTTON_A1 CLICK
						
						//a1_b1_c2 ON TOP
						$("#subject_a1_b1_c2_top_line_on_top").click(function()
						{
							//SHOW TABLE
							$("#a1_b1_c2_table").toggle();
							
							//HIDE OTHER TABLES
							$("#a1_b1_c1_table").toggle(false);
							$("#a1_b2_c1_table").toggle(false);
						});
												
					//B1
						
						//PLAY ICON//FOR IPAD
						$(document).on("click touchstart", "#play_icon_a1_b2_c1", function () {
														
							//OUTPUT
							//UPDATING PLAYS NUMBER//SINGLE
							$.post("metal_6_d_videos.php",
							{
								subject_1:"b1",
								question_1:"Q3",
							},
							function(data, status)
							{
								console.log('OK');
							});
							//END OF UPDATING VIEWS POST REQUEST
							
							//CLICKING PLAY
							setTimeout(function(){ $("#input_08_a1_b2_c1").click(); }, 1000);
						});	
						
						//TOGGLING B1
						$("#subject_a1_b2_c1").click(function()
						{
							//TOGGLE TABLE DISPLAY
							$("#a1_b2_c1_table").toggle();
							
							//CLOSING OTHER OPEN COMMENTS TABLES AND ROWS
							$("#a1_b1_c1_table").toggle(false);
							$("#a1_b1_c2_table").toggle(false);
							
							$("#a1_b1_c2_top_line_on_top").toggle(false);
							$("#a1_b1_c2_top_line_bottom").toggle(false);
						});
						//END OF subject_a1_b2 CLICK
						
						//CHANGE VALUE UPON CLICK
						$("#gotit_a1_b2_c1").click(function()
						{
							//LOCAL COLORS
							$(".a1_b2_c1_main").css("background-color","green");
														
							//OUTPUT
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q3",
								value_1:"1",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});//END OF UPDATING NEW COLOR
						});//END OF gotit_a1 CLICK
						
						$("#dgetit_a1_b2_c1").click(function()
						{
							//LOCAL COLORS
							$(".a1_b2_c1_main").css("background-color","red");
							
							//OUTPUT
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q3",
								value_1:"2",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						});
						//END OF dgetit_a1 CLICK
						
						//CLEAR COLORS
						$("#clear_colors_a1_b2_c1").click(function()
						{
							//LOCAL COLORS
							$(".a1_b2_c1_main").css("background-color","white");
							$(".a1_b2_main").css("background-color","white");
							$("#a1").css("background-color","#A9014B");
							
							//OUTPUT
							//UPDATING
							//UPDATING NEW COLOR
							$.post("metal_6_f_videos.php",
							{
								subject_1:"a1",
								question_1:"Q3",
								value_1:"0",
							},
							function(data, status)
							{
								if(data == 'OK');
								{
									alert('העדכון בוצע בהצלחה.');
								}
							});
							//END OF UPDATING NEW COLOR
						});
						//END OF clear_colors CLICK
						
						//SAVE
						$("#save_button_a1_b2_c1").click(function()
						{
							//SANITIZING FUNCTIONS
							function escapeRegExp(string)
							{
								//return string.replace(/[.*+?^${}<>'()|[\]\\]/g, '\\$&'); // $& means the whole matched string
								string = string.replace("script", "scipbt"); 
								string = string.replace("'", "`"); 
								return string; 
							}
							
							//COMPARING CURRENT & NEW COMMENTS
							function check_current_comment(result)							
							{
								//VARS
								var current_comment = $("#textarea_a1_b2_c1").val();
								var previous_comment = result;
								
								//CASES
								if (current_comment.length == 0 && previous_comment.length == 0)
								{
									alert("אין מה לעדכן.");
								}
								else if (current_comment.length == 0 && previous_comment.length != 0)
								{
									if(confirm("בטוח/ה שאת/ה רוצה למחוק?"))
									{
										if(current_comment.length > 1000)
										{
											alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
										}
										else//UPDATING COMMENT TO NEW COMMENT
										{
											//ESCAPING CHARS
											var text_value = escapeRegExp(current_comment);
											
											//OUTPUT
											//INSERT NEW COMMENT
											$.post("metal_6_videos.php",
											{
												comments_a1: text_value,
												question_1: 'Q3',
											},
											function(data, status)
											{
												alert("ההערה נמחקה בהצלחה.");
											}//END OF POST SUCCESS FUNCTION
											);//END OF POST REQUEST
										}
									}
									else//DOESN'T WANT TO DELETE
									{
										$("#textarea_a1_b2_c1").val(previous_comment);
									}
								}
								else// USUAL COMMENT UPDATE
								{
									if(current_comment.length > 1000)
									{
										alert("ההערה ארוכה מדי, תוכל/י לקצר ואז ללחוץ על שמור שוב."+" ("+current_comment.length+"/1000)");
									}
									else//UPDATING TO NEW COMMENT
									{
										//ESCAPING CHARS
										var text_value = escapeRegExp(current_comment);
										
										//OUTPUT
										//INSERT NEW COMMENT
										$.post("metal_6_videos.php",
										{
											comments_a1: text_value,
											question_1: 'Q3',
										},
										function(data, status)
										{
											alert("ההערה נשמרה בהצלחה.");
										}//END OF POST SUCCESS FUNCTION
										);//END OF POST REQUEST
									}//UPDATE END
								}//USUAL UPDATE END
							}//FUNCTION END
							
							//OUTPUT
							//GETTING CURRENT COMMENT
							$.ajax
							({
								url: 'metal_6_b_videos.php',
								type: 'POST',
								//data: {'Y_n': data_1_js,
								//		'Number_0': num}
								data: {Y_n: 'Q3'}
							}).done(function(result)
							{
								check_current_comment(result); 
							});
						});
						//END OF SAVE_BUTTON_B1 CLICK
						
						//CLICK
						$("#a1_b2").click(function()
						{
							//HIDE OTHER TOP LINES
							$("#a1_b1_top_line").toggle(false);
							$("#a1_b1_c1_top_line").toggle(false);
							$("#a1_b1_c2_top_line_on_top").toggle(false);
							
							//SHOW a1_b2 TOP LINES
							$("#a1_b2_top_line").toggle();
							$("#a1_b2_c1_top_line").toggle();
														
							//CLOSE BOTTOM LINES
							$("#a1_b1_c2_top_line_bottom").toggle(false);
							
							//CLOSE TABLES
							$("#a1_b1_c1_table").toggle(false);							
							$("#a1_b1_c2_table").toggle(false);							
							$("#a1_b2_c1_table").toggle(false);							
								
							//TABLE OPACITY
							$(".a1_b2_table").css("opacity","1");
							$(".a1_b1_table").css("opacity","0.5");
						});
							
						//CANCEL OPACITY
						//RESETING VALUES
						//BACKGROUND COLOR
						$("#cancel_opacity").css("background-color","white");
						$("#cancel_opacity").css("color","black");
						$("#cancel_opacity").html("בטל/י הדגשת נושא");
						
						//CLICK
						$("#cancel_opacity").click(function()
						{
							//BACKGROUND COLOR
							$("#cancel_opacity").css("background-color","green");
							$("#cancel_opacity").css("color","white");
							$("#cancel_opacity").html("הדגשה בוטלה");
							
							//TABLE OPACITY
							$(".a1_b1_table").css("opacity","1");
							$(".a1_b2_table").css("opacity","1");
							
							//UNBIND
							$("#a1_b1").unbind("click");
							$("#a1_b2").unbind("click");
							
							//REBIND TOGGLING
							$("#a1_b1").click(function()
							{
								//HIDE OTHER TOP LINES
								$("#a1_b2_top_line").toggle(false);
								$("#a1_b2_c1_top_line").toggle(false);
																
								//SHOW TOP LINES
								$("#a1_b1_top_line").toggle();
								$("#a1_b1_c1_top_line").toggle();
								$("#a1_b1_c2_top_line_on_top").toggle();
								
								//CLOSE BOTTOM LINES
								$("#a1_b1_c2_top_line_bottom").toggle(false);
								
								//CLOSE TABLES
								$("#a1_b1_c1_table").toggle(false);							
								$("#a1_b1_c2_table").toggle(false);							
								$("#a1_b2_c1_table").toggle(false);							
									
								//TABLE OPACITY
								$(".a1_b2_table").animate({opacity:0.5},1000);
								$(".a1_b1_table").animate({opacity:1},1000);//TABLE OPACITY
								$(".a1_b2_table").animate({opacity:0.5},1000);
								$(".a1_b1_table").animate({opacity:1},1000);
							});
							
							$("#a1_b2").click(function()
							{
								//HIDE OTHER TOP LINES
								$("#a1_b1_top_line").toggle(false);
								$("#a1_b1_c1_top_line").toggle(false);
								$("#a1_b1_c2_top_line_on_top").toggle(false);
								
								//SHOW a1_b2 TOP LINES
								$("#a1_b2_top_line").toggle();
								$("#a1_b2_c1_top_line").toggle();
															
								//CLOSE BOTTOM LINES
								$("#a1_b1_c2_top_line_bottom").toggle(false);
								
								//CLOSE TABLES
								$("#a1_b1_c1_table").toggle(false);							
								$("#a1_b1_c2_table").toggle(false);							
									
								//TABLE OPACITY
								$(".a1_b2_table").animate({opacity:1},1000);
								$(".a1_b1_table").animate({opacity:0.5},1000);
							});//a1_b2 REBIND CLICK
						});//CANCEL OPACITY
						
					//CLOSE TABLES
					//HIDE TOP LINES
					$("#a1_b1_top_line").toggle(false);
					$("#a1_b1_c1_top_line").toggle(false);
					$("#a1_b1_c2_top_line_on_top").toggle(false);
					$("#a1_b2_top_line").toggle(false);
					$("#a1_b2_c1_top_line").toggle(false);
					
					//CLOSE BOTTOM LINES
					$("#a1_b1_c2_top_line_bottom").toggle(false);
					
					//CLOSE TABLES
					$("#a1_b1_c1_table").toggle(false);							
					$("#a1_b1_c2_table").toggle(false);
					$("#a1_b2_c1_table").toggle(false);
					
					}//SUCCESS FUNCTION AFTER POST REQUEST
				);//POST REQUEST
			});//CLICK #a1
			
			//RESET OPACITY ONE TIME
			$("#page_h1").click(function()
			{
				//TABLE AND THS OPACITY TO 1
				$(".a1_b1_table").css("opacity","1");
				$("#a1_b1_table").css("opacity","1");
				
				$(".a1_b2_table").css("opacity","1");
				$("#a1_b2_table").css("opacity","1");
			
				//OPACITY TO 1
				$('#a1_index,#a1_b1_index,#a1_index_h3,.a1_b1_index').animate({opacity:1},1000);
				
				//ONLOAD STUFF
				//TOGGLE INDEX
				$("#a1_index").toggle();
				
				//TOGGLE DISPLAY
				$(".a1_b1_index").toggle(false);
				$("#div_table_drills_2").toggle(false);
			});			
			
			//CLICKS FOR BEGINNING
			$("#page_h1").click();
						
			// setting Timeout
			setTimeout(function(){ $("#n").click(); }, 1000);
			setTimeout(function(){ $("#div_header_3").click(); }, 1000);
			
			//opacity for loader
			$('#div_header_3, #div_table_drills, #hr_number_1, #footer_1, #new_comment, #new_comment_2, #new_comment_form,.a1_b1_index').animate({opacity:1},1000);
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
<?php
}
else
{
	//OUTPUT
	header ("location: ../php/error_fi/error_videos.php");
}
?>