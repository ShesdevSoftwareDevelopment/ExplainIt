<?php

//ERROR DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

//VARS - NONE
	
//INCLUDES - NONE
	
//FUNCTIONS
	
	//OPENING FAR TEXT FILE
	// - GETS USER CODE AND VAR OF NO USE
	// - OPENS FAR FILE AND COPIES DB DETAILS TO ARRAY
	// - RETURNS DB DETAILS ARRAY
	
	function getfile($new_path,$p)
	{
		//GETTING PATH TO FILE
		$t=$new_path;
		//OPENING FILE//OUTPUT 00
		$myfile = fopen("../../../../../../ocartdata/storage/vendor/react/promise/tests/PromiseTest/002/$t.txt", "r") or die("Unable to open file!");
		//GETTING FILE CONTENT//OUTPUT 01
		$r=file_get_contents("../../../../../../ocartdata/storage/vendor/react/promise/tests/PromiseTest/002/$t.txt");
		//CLOSING FILE
		fclose($myfile);
		//SPLITTING BY SPACES
		$p = explode("\n", $r);
		//RETURN DB DETAILS ARRAY
		return $p;
	}
	
?>
