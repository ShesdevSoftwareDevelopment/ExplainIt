<?php
session_start();

// display errors
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

// REDIRECT IF NOT HTTPS
	if($_SERVER["HTTPS"] != "on")
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}	

// POST

	if(isset($_POST['submit_a1_b1_c1']))
	{
		$file=$_FILES['file_a1_b1_c1'];
		// WAS ACTIVE
		//echo '<pre>';
		//var_dump($_POST);
		//var_dump($_FILES);
		//echo '</pre>';
	}

	
?>