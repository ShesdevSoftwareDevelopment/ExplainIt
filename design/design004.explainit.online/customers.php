<!DOCTYPE html>
<html lang="iw" dir="rtl">
<head>
<!-- Document Links -->
	<!-- favicon -->
	<link rel="icon" type="image/png" href="favicon.ico">
	<!-- Encoding -->
	<meta charset="utf-8">
	<!-- Viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Bellefair" rel="stylesheet">
	<!-- Links -->
		<!-- EMOJI CSS -->
		<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
		<!-- Styling-->
<style>
div.gallery {
    margin: 5px auto;
    border: 1px solid #ccc;
    /*float: left;*/
    width: 75%;
	overflow:hidden;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px 0px;
    text-align: center;
}

.container
{
	width:100%;
	text-align:center;
	float:left;
}

.header
{
	/*width:100%;*//* CHANGED */
	width:50%;
	text-align:center;
}

*
{
	font-family: 'Bellefair', serif;
}

/* LIST *//* https://designshack.net/articles/css/5-simple-and-practical-css-list-styles-you-can-copy-and-paste/ */

* {
	margin: 0;
	padding: 0;
}
 
body {
  /*background: #333;*/
}
 
div {
  /*width: 900px;*/
  width: 100%;
  margin: 0 auto;
  overflow: auto;
}
 
ul {
  list-style-type: none;
}
 
li img {
  /* float: left; */
  /* margin: 10px; */
  margin: auto; 
  border: 5px solid #fff;
 
  -webkit-transition: box-shadow 0.5s ease;
  -moz-transition: box-shadow 0.5s ease;
  -o-transition: box-shadow 0.5s ease;
  -ms-transition: box-shadow 0.5s ease;
  transition: box-shadow 0.5s ease;
}
 
li img:hover {
  -webkit-box-shadow: 0px 0px 7px rgba(255,255,255,0.9);
  box-shadow: 0px 0px 7px rgba(255,255,255,0.9);
}

/* GENERAL */
.thumbnail_pic
{
	/*width:150px;*//*CHANGED*/
	width:25%;
	padding:0px;
	border:0.5px black solid;
}

.subjects_div
{
	width:75%;
	text-align:right;
}

.to_complete
{
	background-color:yellow;
}

.initial_width
{
	width:initial;
}
/* @media */
@media only screen and (max-width: 500px)
{
	.header
	{
		/*width:100%;*//* CHANGED */
		width:100%;/*CHANGED FROM 50%*/
		text-align:center;
	}
	
	.subjects_div
	{
		width:75%;
	}
}

</style>
</head>
<body style="max-width:720px;margin:auto;">

<!-- top buttons menu -->
<div class="header">
	<div style="float:right;" class="initial_width">
		<a href="index.html">
			<div class="initial_width" style="margin:2px 2px 1px 0px;padding:0px 2px;border:1px black solid;float:right;">
				עיצוב
			</div>
		</a>
	</div>
	
	<div style="float:right;" class="initial_width">
		<a href="customers.php">
			<div class="initial_width" style="margin:2px 2px 1px 0px;padding:0px 2px;border:1px black solid;float:right;background-color:green;color:white;">
				לקוחות
			</div>
		</a>
	</div>
	
	<div style="float:right;" class="initial_width">
		<a href="documents.php">
			<div class="initial_width to_complete" style="margin:2px 2px 1px 0px;padding:0px 2px;border:1px black solid;float:right;">
				מסמכים
			</div>
		</a>
	</div>
	
	<!-- COURSE WEBSITE -->
	<!-- <div style="float:right;" class="initial_width">
		<a href="#">
			<div class="initial_width" style="margin:2px 2px 1px 0px;padding:0px 2px;border:1px black solid;float:right;">
				אתר קורס
			</div>
		</a>
	</div>
	-->
</div>
<!-- CLIENTS -->
			
<div class="header">
	<div style="width:100%;">	
		<h1 style="margin-bottom:0px;display:inline;">לקוחות</h1>
		<!-- <i class="em em-cookie" style="font-size:16px;"></i> -->
	</div>
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<div style="width:100%;">	
		<h4 style="margin-bottom:0px;display:inline;">מעודכן לתאריך 16.01.19</h4>
	</div>
	
	<!-- PRODUCT DESCRIPTION -->
	
	<div class="header">
		<div style="width:100%;">	
			<h1 style="margin-bottom:0px;display:inline;">&nbsp;</h1>
		</div>
		
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">סה"כ</h4>
		</div>
		
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">1</h4>
		</div>
	</div>
	
	<!-- CLIENTS DATA -->
	
	<div class="header">
		<div style="width:100%;">	
			<h1 style="margin-bottom:0px;display:inline;">&nbsp;</h1>
		</div>
		
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">נרשמו בחודש האחרון</h4>
		</div>
		
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">1</h4>
		</div>
		
		<div style="width:100%;">	
			<h1 style="margin-bottom:0px;display:inline;">&nbsp;</h1>
		</div>
	</div>
	
	<!-- MONEY -->
	
	<div class="header">
			
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">סכום שהועבר עד כה</h4>
		</div>
		
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">108.55 ש"ח</h4>
		</div>
		
		<div style="width:100%;">	
			<h1 style="margin-bottom:0px;display:inline;">&nbsp;</h1>
		</div>
		
		<div style="width:100%;display:none;">	
			<h4 style="margin-bottom:0px;display:inline;">סכום להעברה הקרובה</h4>
		</div>
		
		<div style="width:50%;margin:auto;display:none;">
			<hr>
		</div>
		
		<div style="width:100%;display:none;">	
			<h4 style="margin-bottom:0px;display:inline;"></h4>
		</div>
		
		<div style="width:100%;display:none;">	
			<h1 style="margin-bottom:0px;display:inline;">&nbsp;</h1>
		</div>
	</div>
	
	<!-- UNTIL WHEN COURSE IS OPEN -->
	
	<div class="header">
			
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">תאריך סיום קורס</h4>
		</div>
		
		<div style="width:50%;margin:auto;">
			<hr>
		</div>
		
		<div style="width:100%;">	
			<h4 style="margin-bottom:0px;display:inline;">31.03.19</h4>
		</div>
		
		<div style="width:100%;">	
			<h1 style="margin-bottom:0px;display:inline;">&nbsp;</h1>
		</div>
	</div>
		
	<!-- RECEIPTS -->
	
	<div style="width:100%;">	
		<h4 style="margin-bottom:0px;display:inline;">קבלות</h4>
	</div>
	
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
		
	<div style="width:100%;">	
		<h4 style="margin-bottom:0px;display:none;">(לדוגמא)</h4>
	</div>	
		
	<div style="width:100%;">
		<div style="width:33.33%;float:left;">
			<ul style="width:100%;">
				<li><a target="blank" href="pdf/01.Pdf"><img src="icons/document_pdf.png" /></a></li>
			<!--<li><a target="blank" href="pdf/1.pdf"><img src="icons/document_pdf.png" /></a></li>
				<li><a target="blank" href="pdf/1.pdf"><img src="icons/document_pdf.png" /></a></li>
			-->
			</ul>
		</div>
	</div>
</div>

</body>
</html>