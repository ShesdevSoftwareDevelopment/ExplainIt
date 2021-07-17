<?php
//-->session_start();
//session_start();

// display errors
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');

//vars
	$p = $_SESSION['r'];
	//$p = 'fi';//* CANCEL THIS
	
// includes
	//OUTPUT
	include "$p/test_po_5_add.php";
	
	
//	Functions

	// time func
		
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	
	//CHECKS LENGTH
	function check_length($str)
	{
		//checking length
		if (mb_strlen($str)>=8)
		{
			return TRUE;
		}	
	}
		
	//SETTING CHECK_11
	function set_check_11($new_path)
	{
		
		//DATABASE
		$host = 'localhost';
		$username = 'elad189g_xo_course001';
		$password = 'Wonderfull5600';
		$db = 'elad189g_xo_course001_us';
		
		// creating Connection
		$con = mysqli_connect($host, $username, $password,$db);
				
		$Num = 1;
		$sql = "SELECT * FROM D_videos WHERE U_TP = '$Num' ORDER BY U_I DESC LIMIT 1";
		$query = mysqli_query($con,$sql);
		$row =  mysqli_fetch_array($query,MYSQLI_ASSOC);
		
		// Enabling Hebrew
		mysqli_query($con,"SET character_set_client=utf8mb4");
		mysqli_query($con,"SET character_set_connection=utf8mb4");
		mysqli_query($con,"SET character_set_database=utf8mb4");
		mysqli_query($con,"SET character_set_results=utf8mb4");
		mysqli_query($con,"SET character_set_server=utf8mb4");
				
		if(mysqli_num_rows($query) > 0)
		{
	
			$j=$row['U_V'];
			$i=$row['U_I'];
			$k=$row['U_I']%10;
			
			if($i>0&&$i<11)
			{
				$first = 'a';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>10&&$i<21)
			{
				$first = 'b';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>20&&$i<31)
			{
				$first = 'c';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>30&&$i<41)
			{
				$first = 'd';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>40&&$i<51)
			{
				$first = 'e';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>50&&$i<61)
			{
				$first = 'f';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>60&&$i<71)
			{
				$first = 'g';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>70&&$i<81)
			{
				$first = 'h';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>80&&$i<91)
			{
				$first = 'i';
				if($k == 0)
				{
					$k=10;
				}
			}
			if($i>90&&$i<101)
			{
				$first = 'j';
				if($k == 0)
				{
					$k=10;
				}
			}
			$s=$first.$k;
			//OUTPUT
			$t="elad189g_vid_ex_".$s;
			$v=['a'=>'localhost','b'=>$t,'c'=>$j,'d'=>$t];
	
		}
		
			//updating current index to 0
			$r=$row['U_I'];
			$sql = "UPDATE D_videos SET U_TP = '0' WHERE U_I = '$r'";
			$query = mysqli_query($con,$sql);
			
			//updating next index to 1
			$s=$r+1;
			$sql = "UPDATE D_videos SET U_TP = '1' WHERE U_I = '$s'";
			$query = mysqli_query($con,$sql);
						
			return $v;
		}
	
	// Writing to far file
		function write2farfile($t,$content,$p)
		{
			//OUTPUT
			$myfile = fopen("../../../../../ocartdata/storage/vendor/cardinity/cardinity-sdk-php/spec/Method/Payment/$t.txt", "w") or die("Unable to open file!");//* ONE ../ LESS
				
			$txt = $content['a']."\n";
			fwrite($myfile, $txt);
			
			$txt = $content['b']."\n";
			fwrite($myfile, $txt);
			
			$txt = $content['c']."\n";
			fwrite($myfile, $txt);
			
			$txt = $content['d'];
			fwrite($myfile, $txt);
			
			fclose($myfile);
		}
	
	// Writing to near file
		function write2nearfile($name_1,$t,$p)
		{
			//OUTPUT
			$myfile = fopen("$name_1/check_13.txt", "w") or die("Unable to open file!");
					
			$txt = $t;
			fwrite($myfile, $txt);
					
			fclose($myfile);
		}

		
	// Openning far txt file
		function getfile($new_path,$p)
		{
			//OUTPUT
			$t=$new_path;
			$myfile = fopen("../../../../../ocartdata/storage/vendor/cardinity/cardinity-sdk-php/spec/Method/Payment/$t.txt", "r") or die("Unable to open file!");//* ONE ../ LESS
			
			//OUTPUT
			$r=file_get_contents("../../../../../ocartdata/storage/vendor/cardinity/cardinity-sdk-php/spec/Method/Payment/$t.txt");//* ONE ../ LESS
			
			fclose($myfile);
			
			//splitting by spaces
			$p = explode("\n", $r);
			
			return $p;
	
		}
	
	// Openning near txt file	
		function getnearfile($p)
		{
			//OUTPUT
			$myfile = fopen("$p/check_13.txt", "r") or die("Unable to open file!");
			
			$r=file_get_contents("$p/check_13.txt");
			
			fclose($myfile);
			
			return $r;
		}
	
	//change 0
		function change_0($m)
		{
			for ($i=0;$i<strlen($m);$i++)
			{
				if ($m[$i] == '0')
				{
					$m[$i] = '1';
				}
			}
			return $m;
		}
		
	//DATABSE
	// connecting
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
	mysqli_select_db($con, "elad189g_ex_us"); 
	
	// Enabling Hebrew
	mysqli_query($con,"SET character_set_client=utf8mb4");
	mysqli_query($con,"SET character_set_connection=utf8mb4");
	mysqli_query($con,"SET character_set_database=utf8mb4");
	mysqli_query($con,"SET character_set_results=utf8mb4");
	mysqli_query($con,"SET character_set_server=utf8mb4");
	
	// Setting Time	
	$sql_Time = "SET time_zone = '+03:00';";
    $query = mysqli_query($con,$sql_Time);
	
// Connecting End

//DATA

	if ($_SESSION['a'] == 1)
	//if (1)
	{
		//vars
		date_default_timezone_set('Africa/Cairo');
		
		//TIMESTAMP
		$t_s = strval(microtime_float());//GETTING TIME
		$t_s = change_0($t_s);//CHANGING 0
		
		$na=date('Y-m-d-His');
		$nam=date('Y-m-d-His-').$t_s;
		
		//CREATING FOLDER
		//OUTPUT
		$name_1="$p/logs_2/$nam";
		mkdir($name_1,0755);
		
		//CREATING FAR TXT FILE - DB QUERY
		$check_set = set_check_11(0);
		
		//CREATING FAR TXT FILE - WRITING TO FILE
		write2farfile($t_s,$check_set,$p);
		
		//CREATING NEAR TXT FILE - WRITING TO FILE
		write2nearfile($name_1,$t_s,$p);
		
		//GETTING DATA
		$f = getnearfile($name_1);
		$get_back = getfile($f,$p);
		
			
		$_SESSION['a'] = 0;
		
		//DEBUGGING
	/*	echo '<pre>';
		var_dump($get_back);
		echo '</pre>';
	*/
	}
	else
	{
	
		//OUTPUT
		header ('location: ../error_fi/error_videos.php');//* ONE ../ LESS
	}
?>
