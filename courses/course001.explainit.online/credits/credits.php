<html>
<head>
<!-- ENCODING -->
	<meta charset="utf-8">
	
	<!-- FAVICON --><!-- OUTPUT 00 -->
	<link rel="icon" type="image/png" href="../css/favicon.ico">
	
	<!-- APPLE TOUCH ICON --><!-- OUTPUT 01 -->
	<link rel="apple-touch-icon" sizes="57x57" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="../css/favicon.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="../css/favicon.png" />
	
	<!-- CSS --><!-- OUTPUT 02 -->
	<link rel="stylesheet" href="../css/2.css">
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- IOS PHONES -->
	<meta name="format-detection" content="telephone=no">
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
		
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

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

.header_100
{
	/*width:100%;*//* CHANGED */
	width:100%;
	text-align:center;
}


*
{
	font-family: 'Secular One', sans-serif;
}

/* LIST *//* https://designshack.net/articles/css/5-simple-and-practical-css-list-styles-you-can-copy-and-paste/ */

* {
	margin: 0;
	padding: 0;
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
  float: left;
  margin: 10px;
  /*border: 5px solid #fff;*/
 
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

.to_fix
{
	background-color:lightblue;
}

.initial_width
{
	width:initial;
}

#container
{
	width:75%;
	margin:auto;
}

/* @media */
@media only screen and (max-width: 710px)
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
	
	#container
	{
		width:100%;
	}
	
	li img
	{
		width:48%;
		margin:1%;
		float: left;
		border: 0px;
	}
	
	#container_li
	{
		text-align:center;
	}
}

</style>
</head>

<body style="max-width:720px;margin:auto;">

<!-- CONTENT -->

<div class="header">
	<!-- HEADER -->
	<div style="width:100%;">	
		<h1>קרדיטים</h1>
	</div>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;padding:0px 0px 6px;">
		<hr>
	</div>
</div>

<div class="header_100">
	
	<!-- CREDITS GALLERY -->
	
	<div id="container">
		<ul id="container_li">
			<li><a href="https://www.flaticon.com/"><img src="../img/credits/01.jpg" /></a></li>
			<li><a href="https://afeld.github.io/emoji-css/"><img src="../img/credits/02.jpg" /></a></li>
			<li><a href="https://www.pexels.com/"><img src="../img/credits/03.jpg" /></a></li>
			<li><a href="https://favicon.io/emoji-favicons/"><img src="../img/credits/04.jpg" /></a></li>
			<li><a href="https://archive.org/details/bibleprimeroldte00hult"><img src="../img/credits/05.jpg" /></a></li>
			<li><a href="https://commons.wikimedia.org/wiki/Main_Page"><img src="../img/credits/06.jpg" /></a></li>
			<li><a href="https://www.gimp.org/"><img src="../img/credits/07.jpg" /></a></li>
			<li><a href="https://notepad-plus-plus.org/download/v7.5.8.html"><img src="../img/credits/08.jpg" /></a></li>
			<li><a href="https://www.youtube.com/"><img src="../img/credits/09.jpg" /></a></li>
			<li><a href="https://stackoverflow.com/"><img src="../img/credits/10.jpg" /></a></li>
			<li><a href="https://www.w3schools.com/"><img src="../img/credits/11.jpg" /></a></li>
			<li><a href="https://www.codecademy.com/"><img src="../img/credits/12.jpg" /></a></li>
			<!-- <li><a href="#"><img src="http://placehold.it/150x150" /></a></li> -->
		</ul>
	</div>
</div>

</body>
</html>