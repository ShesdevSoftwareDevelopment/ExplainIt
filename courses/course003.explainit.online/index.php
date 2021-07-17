<?php

// SESSION START
	session_start();

// ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

// HTTPS REDIRECT
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
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
	
<!-- LINKS -->
	
	<!-- FAVICON --><!-- OUTPUT 01 -->
	<link rel="icon" type="image/png" href="css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 02 -->
	<link rel="apple-touch-icon" sizes="57x57" href="css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 03 -->
	<link rel="stylesheet" href="css/2.css">
	
	<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- TITLE -->
	<title>Explainit Online - קורס 003</title>
	
	<!-- DESCRIPTION -->
	<meta name="description" content='קורס תנ"ך לבגרות, מלכים ב וירמיה.'>
		
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- FONT AWESOME -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	
	<!-- STYLE -->
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
			background: #A9014B url(css/button_overlay.png) repeat-x scroll 0 0;/* OUTPUT 04 */
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

/* General stuff 2.css */
			
			.responsive
			{
				width:50%;
				height:36px;
			}
									
			section, footer, nav {
			display: block;
			}
			
			body {
			font-family: 'Varela Round', sans-serif;
			-webkit-text-size-adjust: none;
			color: #f9f1f1;
			max-width: 720px;
			margin: 0 auto;
			padding: 10px;
			/* Background pattern from Toptal Subtle Patterns */
			background-image:url("img/background/grey_wash_wall.png");
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
			
			button {
			font-size: 16px;
			-webkit-appearance: push-button;
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
					font-family: 'Secular One', sans-serif;
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
					
					div[contenteditable]
					{
						border: 1px solid black;
						max-height: 200px;
						overflow: auto;
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
							
						#table_drills 
						{
							width:100%;
							margin:auto;
							border:1px solid black;
							text-align:center;
							border-collapse:collapse;
						}
						
						#table_drills th 
						{
							border:1px solid black;
							border-collapse:collapse;
						}
						
						#table_drills td 
						{
							border:1px black solid;
							border-right-style:ridge;
						}
						
						#table_colors td 
						{
							padding:2px 10px;
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
						#div_1,
						#div_table_drills,
						#hr_number_1,
						#new_comment,
						#footer_1
						{opacity:0;}
						
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
			color: #f9f1f1;
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
			
/* TABLES */

	/* ALL TABLES */
	table :hover
	{
		cursor:pointer;
	}

	/* METAL TABLES*/

	/* B0 */
	
	#table_b0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b0 td, #table_b0 th
	{
		border-collapse: collapse;
	}
	
	/* B01 */
	
	#table_b01
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b01 td, #table_b01 th
	{
		border-collapse: collapse;
	}
	
	
	/* B1 */
	
	#table_b1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b1 td, #table_b1 th
	{
		border-collapse: collapse;
	}
	
	/* B2 */
	
	#table_b2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b2 td, #table_b2 th
	{
		border-collapse: collapse;
	}
	
	.tr_border
	{
		border: 1px solid black;
	}
	
	/* B3 */
	
	#table_b3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b3 td, #table_b3 th
	{
		border-collapse: collapse;
	}

	/* B4 */
	
	#table_b4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b4 td, #table_b4 th
	{
		border-collapse: collapse;
	}
	
	/* B5 */
	
	#table_b5
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b5 td, #table_b5 th
	{
		border-collapse: collapse;
	}

	/* B6 */
	
	#table_b6
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b6 td, #table_b6 th
	{
		border-collapse: collapse;
	}
	
	/* B7 */
	
	#table_b7
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b7 td, #table_b7 th
	{
		border-collapse: collapse;
	}
	
	/* b8 */
	
	#table_b8
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b8 td, #table_b8 th
	{
		border-collapse: collapse;
	}
	
	/* B9 */
	
	#table_b9
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b9 td, #table_b9 th
	{
		border-collapse: collapse;
	}
	
	/* B10 */
	
	#table_b10
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b10 td, #table_b10 th
	{
		border-collapse: collapse;
	}
	
	/* B11 */
	
	#table_b11
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b11 td, #table_b11 th
	{
		border-collapse: collapse;
	}

	/* B12 */
	
	#table_b12
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b12 td, #table_b12 th
	{
		border-collapse: collapse;
	}
	
	/* B13 */
	
	#table_b13
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b13 td, #table_b13 th
	{
		border-collapse: collapse;
	}
	
	/* B14 */
	
	#table_b14
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b14 td, #table_b14 th
	{
		border-collapse: collapse;
	}
	
	/* B15 */
	
	#table_b15
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b15 td, #table_b15 th
	{
		border-collapse: collapse;
	}
	
	/* B16 */
	
	#table_b16
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_b16 td, #table_b16 th
	{
		border-collapse: collapse;
	}


	/* d0 */
	
	#table_d0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_d0 td, #table_d0 th
	{
		border-collapse: collapse;
	}
	
	/* d1 */
	
	#table_d1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_d1 td, #table_d1 th
	{
		border-collapse: collapse;
	}
	
	/* d2 */
	
	#table_d2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_d2 td, #table_d2 th
	{
		border-collapse: collapse;
	}
	
	/* d3 */
	
	#table_d3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_d3 td, #table_d3 th
	{
		border-collapse: collapse;
	}
	
	/* d4 */
	
	#table_d4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_d4 td, #table_d4 th
	{
		border-collapse: collapse;
	}


	/* e0 */
	
	#table_e0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_e0 td, #table_e0 th
	{
		border-collapse: collapse;
	}
	
	/* e1 */
	
	#table_e1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_e1 td, #table_e1 th
	{
		border-collapse: collapse;
	}
	
	/* e2 */
	
	#table_e2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_e2 td, #table_e2 th
	{
		border-collapse: collapse;
	}
	
	/* e3 */
	
	#table_e3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_e3 td, #table_e3 th
	{
		border-collapse: collapse;
	}
	
	/* e4 */
	
	#table_e4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_e4 td, #table_e4 th
	{
		border-collapse: collapse;
	}

	/* f0 */
	
	#table_f0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_f0 td, #table_f0 th
	{
		border-collapse: collapse;
	}
	
	/* f1 */
	
	#table_f1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_f1 td, #table_f1 th
	{
		border-collapse: collapse;
	}
	
	/* f2 */
	
	#table_f2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_f2 td, #table_f2 th
	{
		border-collapse: collapse;
	}
	
	/* f3 */
	
	#table_f3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_f3 td, #table_f3 th
	{
		border-collapse: collapse;
	}
	
	/* f4 */
	
	#table_f4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_f4 td, #table_f4 th
	{
		border-collapse: collapse;
	}
	
	/* g0 */
	
	#table_g0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_g0 td, #table_g0 th
	{
		border-collapse: collapse;
	}
	
	/* g1 */
	
	#table_g1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_g1 td, #table_g1 th
	{
		border-collapse: collapse;
	}
	
	/* g2 */
	
	#table_g2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_g2 td, #table_g2 th
	{
		border-collapse: collapse;
	}
	
	/* g3 */
	
	#table_g3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_g3 td, #table_g3 th
	{
		border-collapse: collapse;
	}
	
	/* g4 */
	
	#table_g4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_g4 td, #table_g4 th
	{
		border-collapse: collapse;
	}

	/* h0 */
	
	#table_h0
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_h0 td, #table_h0 th
	{
		border-collapse: collapse;
	}
	
	/* h1 */
	
	#table_h1
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_h1 td, #table_h1 th
	{
		border-collapse: collapse;
	}
	
	/* h2 */
	
	#table_h2
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_h2 td, #table_h2 th
	{
		border-collapse: collapse;
	}
	
	/* h3 */
	
	#table_h3
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_h3 td, #table_h3 th
	{
		border-collapse: collapse;
	}
	
	/* h4 */
	
	#table_h4
	{
		width: 100%;
		margin: auto;
		text-align: center;
		border-collapse: collapse;
	}
	
	#table_h4 td, #table_h4 th
	{
		border-collapse: collapse;
	}
		
	/* ID */
	
	#in_1, #in_2
	{
		width:99%;
		padding-top:8px;
		padding-bottom:8px;
	}
	
	#in_3
	{
		margin-top:5px;
	}
	
	#div_header_5
	{
		width:49%;
		margin-right:5px;
	}
	
	#div_header_4
	{
		margin:0px;
		/*width:49%;*/
		width:100%;
		float:right;
	}
	
	#div_header_4_1
	{
		margin-right:5px;
		width:49%;
		float:left;
	}
	
	.responsive_input_2
	{
		background-color:green;
	}
	
	.responsive_input_2,
	.responsive_input_3
	{
		font-size:16px;
	}
	
	.responsive_input_4
	{
		width:49%;
		height:36px;
		margin:4px 2px;
		padding:6px;
		font-size:16px;
	}
	
	.responsive_input_5
	{
		width:100%;
		height:36px;
		margin:4px 2px;
		padding:6px;
		font-size:16px;
	}
		
	.abs
		{
			position:absolute;
			margin-top:6px;
		}
		
	.frame
		{
		/*	
			float:right;
			width:48%;
			margin:5px;
		*/
		}
	
	.log_in
		{
			margin-right:0px;
			margin-bottom:5px;
			width:33%;
		}
	
	#lecturer_page
		{
			width:100%;
		}
	
	/* HEADER *//*https://css-tricks.com/creating-non-rectangular-headers/*/
	
	header
	{
	position: relative;
	overflow: hidden;
	width:100%;
	z-index:-1;
	}
	
	header h1,header h1 i 
	{
	margin: 0;
	padding: 25px 0 0;
	font-size: 44px;
	text-align: center;
	position: relative;
	color: black;
	}
	
	section h1 
	{
		margin: 0;
		padding: 0px 0;
		font-size: 44px;
		text-align: center;
	}
	
	#log_in
	{
		background-color:green;
	}
	
	/* @ MEDIA */
	@media only screen and (max-width: 710px)
	{
		.frame
		{	
		/*  
			width: 100%;
			float: right;
		*/
		}
		
		.abs
		{
			position:relative;
			margin-top:0px;
		}
			
		header 
		{
			top:0px;
			z-index:0;
		}
		
		header h1 
		{
			padding: 10px 0 0;
		}
		
		header h1 i 
		{
			margin: 0;
			padding: 10px 0 0;
			font-size: 32px;
			text-align: center;
			position: relative;
			color: black;
		}
		
		.responsive 
		{
			width: 100%;
		}
		
		.responsive_input
		{
			width:70%;
			height:36px;
			margin:4px 2px;
			padding:2px;
			font-size:16px;
		}
		
		.responsive_input_2,
		.responsive_input_3
		{
			height:36px;
			margin:4px 2px;
			padding:6px;
			font-size:16px;
		}
		
		.responsive_input_4
		{
			width:96%;
			height:36px;
			margin:4px 2px;
			padding:6px;
			font-size:16px;
		}
		
		.responsive_input_5
		{
			width:100%;
			height:36px;
			margin:4px 2px;
			padding:6px;
			font-size:16px;
		}
		
		.log_in
		{
			margin-right:0px;
			width:48%;
			float:left;
			margin-left:1%;
		}
		
		#lecturer_page
		{
			width:97%;
		}
				
		#div_header_5,#log_in,#log_in_too
		{
			/*margin-right:0px;*/
			width:48%;
			float:right;
			margin-left:1%;
		}
		
		#div_header_4,#div_header_4_1,#log_in_2
		{
			margin-right:0px;
			width:100%;
		}
		
		#div_in_2
		{
			margin-top:5px;
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

	/* W3 IMAGE GALLERY *//* https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_slideshow_gallery */
	
	img 
	{
		vertical-align: middle;
	}
	
	/* Hide the images by default */
	.mySlides {
	display: none;
	height:300px;
	z-index:-2;
	float:right;
	width:100%;
	}
	
	/* Add a pointer when hovering over the thumbnail images */
	.cursor {
	cursor: pointer;
	}
	
	/* Next and previous buttons */
	.prev,
	.next {
	cursor: pointer;
	/*position: absolute;*/
	top: 50%;
	width: auto;
	padding: 16px;
	margin-top: -50px;
	color: white;
	font-weight: bold;
	font-size: 20px;
	border-radius: 0 3px 3px 0;
	user-select: none;
	-webkit-user-select: none;
	}
	
	/* Position the "next button" to the right */
	.next {
	right: 0;
	border-radius: 3px 0 0 3px;
	}
	.prev {
	left: 0;
	border-radius: 3px 0 0 3px;
	}
	
	/* On hover, add a black background color with a little bit see-through */
	.prev:hover,
	.next:hover {
	background-color: rgba(0, 0, 0, 0.8);
	}
	
	/* Number text (1/3 etc) */
	.numbertext {
	display:none;
	color: #f2f2f2;
	font-size: 12px;
	padding: 8px 12px;
	float:right;
	top: 0;
	}
	
	/* Container for image text */
	.caption-container {
	text-align: center;
	background-color: #222;
	padding: 2px 16px;
	color: white;
	}
	
	.row:after {
	content: "";
	display: table;
	clear: both;
	}
	
	/* Six columns side by side */
	.column {
	float: left;
	/*width: 16.66%;*/
	width:25%;
	}
		
	/* Add a transparency effect for thumnbail images */
	.demo {
	opacity: 0.6;
	}
	
	@media only screen and (max-width: 500px)
	{
		/* Six columns side by side */
		.column
		{
			float: left;
			width: 50%;
		}
	}
	.active,
	.demo:hover {
	opacity: 1;
	}
	
	/* YOUTUBE LIGHT EMBED *//*https://www.labnol.org/internet/light-youtube-embeds/27941/*/
	
	.youtube-player {
        position: relative;
        padding-bottom: 56.23%;
        /* Use 75% for 4:3 videos */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
        margin: 5px;
    }
    
    .youtube-player iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 100;
        background: transparent;
    }
    
    .youtube-player img {
        bottom: 0;
        display: block;
        left: 0;
        margin: auto;
        max-width: 100%;
        width: 100%;
        position: absolute;
        right: 0;
        top: 0;
        border: none;
        height: auto;
        cursor: pointer;
        -webkit-transition: .4s all;
        -moz-transition: .4s all;
        transition: .4s all;
    }
    
    .youtube-player img:hover {
        -webkit-filter: brightness(75%);
    }
    
    .youtube-player .play {
        height: 72px;
        width: 72px;
        left: 50%;
        top: 50%;
        margin-left: -36px;
        margin-top: -36px;
        position: absolute;
        background: url("//i.imgur.com/TxzC70f.png") no-repeat;
        cursor: pointer;
    }
	
	input[type="submit"]
	{
		font-family:secular one, sans-serif;
	}
	</style>
	<!-- Hotjar Tracking Code for https://course003.explainit.online -->
	<script>
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			h._hjSettings={hjid:1287839,hjsv:6};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			a.appendChild(r);
		})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script>
</head>

<body style="width:100%;position:relative;">

	<!-- LOADER DIV -->
	<div class="loader"></div>
		
	<!-- LOADER SCRIPT -->
	<script>
		//logging initiation
		console.log("---loader")
			
		//setting width variable
			var a_11_loader = $(document.body).outerWidth()/2-60;
			
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
	</script><!-- LOADER SCRIPT -->		
		
<!-- COMMERCIALS -->	
	<!--	
		<div class="commercial" style="position:absolute;right:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;right:-206px;top:220px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;right:-206px;top:430px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;right:-206px;top:640px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;right:-206px;top:850px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
	-->		
		<!--<div class="commercial" style="position:absolute;left:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"><img src="pics/saved.png" style="width:100%;"></div>-->
	<!--<div class="commercial" style="position:absolute;left:-206px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;left:-206px;top:220px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;left:-206px;top:430px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;left:-206px;top:640px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
		<div class="commercial" style="position:absolute;left:-206px;top:850px;/*background-color:orange;*/width:200px;height:200px;border:1px black dashed;"></div>
	-->
		
<!-- MIDDLE CONTENT -->	
	<div id="middle_content" style="float:right;width:100%;text-align:center;max-width:720px;">
	
	<div style="width:100%;text-align:center;float:right;display:none;">
		<h1>22.10.18</h1>
	</div>
		
		<header>
				
		<div style="width:100%;">
			<!-- OUTPUT 07 --><!-- COURSE BANNER -->
				<img src="img/index/11.jpg" style="width:100%">
			</div>
		</header>
		
		<!-- subjects module -->
		<div id="div_first_time">
			<div style="width:100%;margin:auto;text-align:center;float:right;"> 
				
				<!-- TOP BUTTONS MENU -->
				
				<div id="div_header_4" style="float:right;text-align:center;">
				<!-- OUTPUT 05 --><!-- LOGIN PAGE -->
					<a href="login/example_cleveland_l_videos.php">
						<input id="log_in" class="responsive_input_4 button" type="submit" value="התחברות" name="register">
					</a>
					
					<!-- SIGN UP --><!-- OUTPUT 08 -->
					<a href="login/example_cleveland.php">
						<input id="log_in_too" class="responsive_input_4 button" type="submit" value="לקניית הקורס" name="register">
					</a>
				</div>
				
				<!-- DIV -->
				<div id="div_header_4_1" style="float:right;"></div>
				
				<!-- HR -->
				<div style="width:100%;margin:auto;float:right;">
					<div style="width:50%;margin:auto;">
						<hr>
					</div>
				</div>
			</div>
			
			<div style="width:100%;margin:auto;text-align:center;float:right;">
				<!-- TEXT -->
				<p>
					אנחנו מוכרים מנוי לחבילת סרטונים להכנה לבגרות הקרובה בתנ"ך.
					
					עלות החבילה <b>100 ש"ח</b> (במקום <s>180 ש"ח</s>).
					
					תוכל/י לצפות בהם כמה זמן שתרצה/י.
				</p>
				
				<!-- HR -->
				<div style="width:50%;margin:auto;">
					<hr>
				</div>
			</div>
		</div>
		
		<!-- W3 IMAGE GALLERY -->
		<section style="display:block;">
			<h1>סרטונים לדוגמה</h1>
		</section>
		
		<!-- YOUTUBE PLAYER -->
		<iframe class="frame" width="100%" height="100%" src="https://www.youtube.com/embed/1PiGPdF0kAw?showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> 
		<iframe class="frame" width="100%" height="100%" src="https://www.youtube.com/embed/Xf_pEdfUNvM?showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> 
		<iframe class="frame" width="100%" height="100%" src="https://www.youtube.com/embed/GyfmKEZz8JM?showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> 
		<iframe class="frame" width="100%" height="100%" src="https://www.youtube.com/embed/qQnPtQJ7zrg?showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> 
		
		<!-- SUBJECTS MODULE -->
		<div id="div_first_time" style="float:right;text-align:center;width:100%;margin-top:0px;position:relative;top:0px;">
			<div style="width:100%;margin:auto;text-align:center;"> 
				
				<!-- HR -->
				<div style="width:50%;margin:auto;">
					<hr>
				</div>
				
				<div style="width:100%;margin:auto;">
					<!-- SIGN UP --><!-- OUTPUT 09 -->
					<a href="login/example_cleveland.php">
						<input id="in_3" class="responsive_input_4 button" style="width:100%;" type="submit" value="לקניית הקורס" name="register">
					</a>
				</div>
				
				<!-- HR -->
				<div style="width:50%;margin:auto;">
					<hr>
				</div>
								
				<!-- TEXT -->
				<p>
					אנחנו מוכרים מנוי לחבילת סרטונים להכנה לבגרות הקרובה בתנ"ך.
					
					עלות החבילה <b>100 ש"ח</b> (במקום <s>180 ש"ח</s>).
					
					תוכל/י לצפות בהם כמה זמן שתרצה/י.
				</p>
				<!-- HR -->
				<div style="width:50%;margin:auto;">
					<hr>
				</div>
			</div>
		</div>
		
		<div id="div_header_3" style="float:right;text-align:center;font-size:24px;position:relative;top:0px;width:100%;">
			<!-- HEADER -->
			<h1 style="margin-bottom:0px 0px 0px 0px;font-size:24px;">סרטונים לדוגמה לפי נושא</h1>						
			
			<!-- HR -->
			<div style="width:50%;margin:auto;">
				<hr>
			</div>
			
			<!-- SELECT SUBJECT -->
			<div id="div_table_drills" style="width:100%;margin:auto;text-align:center;">
				<h3 id="choose_subjects" style="font-size:16px;">בחר/י נושא מהרשימה.</h3>
			</div>
		</div>
		
		<div id="div_table_drills_2" style="width:100%;margin:auto;"></div>
		
		<div id="div_1"></div><!-- not sure if needed -->
	
	<!-- HR BEFORE FOOTER -->    
		<div style="width:100%;float:right;">
			<br>
			<hr>
		</div>
	
	</div>

	<!-- FOOTER --><!-- OUTPUT 10 -->
	<footer id="footer_1" style="float:right;clear:both;width:100%;position:relative;">
		<div style="float:right;clear:both;text-align:center;margin-top:5px;width:100%;text-align:center;">
			<table style="width:100%;">
				<tr>
					<td colspan="6">
						<!-- OUTPUT --><!-- ABOUT -->
						<a href="https://explainit.online/boazstavi/index.php">
							<input id="lecturer_page" class="responsive_input_2 button log_in" style="background-color:#329BFD" type="submit" value="דף מרצה" name="register">
						</a>
					</td>
				</tr>
				<tr>			
					<td style="width:16.67%;">	
						<!-- OUTPUT 12 --><!-- ABOUT -->
						<a href="terms/about_xo.jpg">
							<img src="buttons/01.jpg" style="width:100%;">
						</a>
					</td>	
					<td style="width:16.67%;">	
						<!-- OUTPUT 13 --><!-- TERMS -->
						<a href="terms/Terms of Service 04.04.19.pdf">
							<img src="buttons/02.jpg" style="width:100%;">
						</a>
					</td>	
					<td style="width:16.67%;">	
						<!-- OUTPUT 14 --><!-- PRIVACY -->
						<a href="terms/Privacy_Statement_02.08.18.pdf">
							<img src="buttons/03.jpg" style="width:100%;">
						</a>
					</td>	
					<td style="width:16.67%;">	
						<!-- OUTPUT 15 --><!-- CONTACT PAGE -->
						<a href="contact/contact.php">
							<img src="buttons/04.jpg" style="width:100%;">
						</a>
					</td>	
					<td style="width:16.67%;">	
						<!-- OUTPUT 15_1 --><!-- CONTACT PAGE -->
						<a href="credits/credits.php">
							<img src="buttons/05.jpg" style="width:100%;">
						</a>
					</td>	
					<td style="width:16.67%;">	
						<!-- OUTPUT 06 --><!-- INTERESTED IN WEBSITE -->
						<a href="login/first_time/first_time_2.php">
							<img src="buttons/06.jpg" style="width:100%;">
						</a>
					</td>	
				</tr>
			</table>
		</div>
	
		<!-- ADDITIONAL COURSES -->
		<div style="width:100%;margin:auto;">
			<!-- SUBJECT 16 -->
			<table id="table_b17" style="margin-top:2.5px;">
				<tr>
					<!-- ICON --><!-- OUTPUT -->
					<th style="width:30px;border-style:none;"><img class="output" src="img/icons/BOOKS_2.png" style="width:95%;"></td>
					
					<!-- SUBJECT 16 -->
					<th id="b17_1" colspan="3" style="border-top:none;border-left:none;border-bottom:none;">
						<div style="width:100%;margin:auto;">
							<a href="https://explainit.online#courses_menu">
								<input class="responsive_input_4 button" style="width:100%;" type="submit" value="קורסים נוספים" name="register">
							</a>
						</div>
					</th>
				</tr>
				
				<!-- HORIZONTAL LINE -->
				<tr class="b17">
					<td colspan="5" style="border-right-style:none;"><hr></td>
				</tr>
				
				<!-- BACKGROUND IMAGE AND YOUTUBE VIDEO --><!-- OUTPUTS -->
				<tr class="b17">
					<td colspan="5" style="text-align:center;padding:2px 10px;border-right-style:none;position:relative;">
						<!-- OUTPUT 02 --><!-- SUBJECT BACKGROUND PIC -->
						<img class="output" src="img/login/background_pic/IMG_2793.jpg" style="width:75%;opacity:0;display:none;">
						<!-- OUTPUT 03 --><!-- SUBJECT 16 DEMO VID -->
						<div style="position:relative;">
							<a href="https://course001.explainit.online">
								<img src="https://explainit.online/preview/01.jpg" style="width:100%;">
							</a>
						</div>
					</td>
				</tr>
				
				<!-- I WANNA BUY BUTTON --><!-- OUTPUTS -->
				<tr class="b17">
					<td colspan="5" style="border-right-style:none;text-align:center;border-right-style:none;position:relative;">
						<div style="width:100%;text-align:center;">
							<!-- OUTPUT --><!-- SIGN UP PAGE --><a href="https://course001.explainit.online">
								<input class="responsive_input_5 button" type="submit" value="לצפייה בקורס" name="register">
							</a>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<!-- ADDITIONAL COURSES -->
	
	</footer>
	<!-- FOOTER -->

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
		
		var a_11_loader = $(document.body).outerWidth()/2-60;
		//console.log(a_11_loader);
		var a_12_loader = $(window).outerHeight()/2-60;
		$('.loader').css("left",a_11_loader);
		$('.loader').css("top",a_12_loader);
	}
	
	<!-- document ready script -->
	$(document).ready(function()
	{
	
	//GET VISIT DATA
		<!-- OUTPUT --><!-- POST REQUEST -->
		$.post("php/mail_fi/mail_interest_2.php",
		{
			subject:"Series"	,
			subsubject:"Heshbonit"	,
		},
			function(data, status)
			{
				console.log("data ok");
			}
		);//GET VISIT DATA
	
	//clickability	
		$("#choose_subjects").click(function()
		{
			<!-- OUTPUT 11 --><!-- POST REQUEST -->
			$.post("php/metal_fi/metal_5_videos.php",
			{
				subject:"Series"	,
				subsubject:"Heshbonit"	,
			},
				function(data, status)
				{
					$("#div_table_drills_2").html(data);
										
					//B1
					
					$("#b1_1").click(function()
					{
						$(".b1").toggle();
					});
						
					//B2
					
					$("#b2_1").click(function()
					{
						$(".b2").toggle();
					});
						
					//B3
					
					$("#b3_1").click(function()
					{
						$(".b3").toggle();
					});
					
					//B4
					
					$("#b4_1").click(function()
					{
						$(".b4").toggle();
					});
						
					//B5
					
					$("#b5_1").click(function()
					{
						$(".b5").toggle();
					});
						
					//B6
					
					$("#b6_1").click(function()
					{
						$(".b6").toggle();
					});
										
					//B7
					
					$("#b7_1").click(function()
					{
						$(".b7").toggle();
					});
					
					//B8
					
					$("#b8_1").click(function()
					{
						$(".b8").toggle();
					});
					
					//B9
					
					$("#b9_1").click(function()
					{
						$(".b9").toggle();
					});
						
					//B10
					
					$("#b10_1").click(function()
					{
						$(".b10").toggle();
					});
										
					//B11
					
					$("#b11_1").click(function()
					{
						$(".b11").toggle();
					});
					
					//B12
					
					$("#b12_1").click(function()
					{
						$(".b12").toggle();
					});
					
					//B13
					
					$("#b13_1").click(function()
					{
						$(".b13").toggle();
					});
					
					//B14
					
					$("#b14_1").click(function()
					{
						$(".b14").toggle();
					});
					
					//B15
					
					$("#b15_1").click(function()
					{
						$(".b15").toggle();
					});
					
					//B16
					
					$("#b16_1").click(function()
					{
						$(".b16").toggle();
					});
						
					//CLICKS
					//b
					$("#b1_1").click();
					$("#b2_1").click();
					$("#b3_1").click();
					$("#b4_1").click();
					$("#b5_1").click();
					$("#b6_1").click();
					$("#b7_1").click();
					$("#b8_1").click();
					$("#b9_1").click();
					$("#b10_1").click();
					$("#b11_1").click();
					$("#b12_1").click();
					$("#b13_1").click();
					$("#b14_1").click();
					$("#b15_1").click();
					$("#b16_1").click();
					
				}
			);
		});	
		
		//CLICKS
		$("#choose_subjects").click(); 
		
		// setting Timeout
		//setTimeout(function(){ $("#n").click(); }, 1000);
		//setTimeout(function(){ $("#div_header_3").click(); }, 1000);
		
		//debugging
		//console.log("d_once outside",d_once);
		//console.log("c_once outside",c_once);
				
		//opacity for loader
		$('#div_header_3, #div_1, #div_table_drills, #hr_number_1, #footer_1, #new_comment, #new_comment_2, #new_comment_form').animate({opacity:1},1000);
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