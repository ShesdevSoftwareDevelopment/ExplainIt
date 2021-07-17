<?php
//SESSION START
	session_start();

//ERRORS DISPLAY
//	error_reporting(E_ALL);
//	ini_set('display_errors', 'On');

// Data
//USER CAME FROM WLBACK_VIDEOS OR WLBACK_VIDEOS_2
if(isset($_SESSION["refresh_count"]) &&  $_SESSION["refresh_count"] < 3)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{	
		// CHECKING REFERER
		//if($_SERVER["HTTP_REFERER"] == "https://direct.tranzila.com/process/?cc") 
		if(strpos($_SERVER["HTTP_REFERER"], 'https://direct.tranzila.com/process') !== false)
		{
			//DATABASE//CONNECTING//DATA
			//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
			include "../php/test_fi/test_po_7.php";
				
			//GET DB DETAILS
			$new_path = 'test_01';
			$db_details = getfile($new_path,12);
				
			//CONNECTING//DATABASE//DATA
			
			$host = $db_details[0];
			$username = $db_details[1];
			$password = $db_details[2];
			$db = $db_details[3];
			
			//CREATING CONNECTION
			$con = mysqli_connect($host, $username, $password,$db);
			
			//CHECKING CONNECTION
			if($con)
			{
				//echo '<i class="fa fa-check-square-o" style="font-size:24px;color:purple;"></i>';
				//echo 'connection ok';
			}
			else
			{
				die('Could not connect: ' . mysqli_error($con));
			}
				
			//SELECTING DATABASE
			mysqli_select_db($con, $db_details[3]); 
			
			//ENABLING HEBREW
			mysqli_query($con,"SET character_set_client=utf8mb4");
			mysqli_query($con,"SET character_set_connection=utf8mb4");
			mysqli_query($con,"SET character_set_database=utf8mb4");
			mysqli_query($con,"SET character_set_results=utf8mb4");
			mysqli_query($con,"SET character_set_server=utf8mb4");
			
			//SETTING TIME	
			$sql_Time = "SET time_zone = '+03:00';";
			$query = mysqli_query($con,$sql_Time);
		
		//SANITIZING POST VARS
			$P=array();
			$P[0]=$con->real_escape_string($_POST["Response"]); 	                  //string(3) "000"
			$P[1]=$con->real_escape_string($_POST["ipsp"]);     	                  //string(1) "1"
			$P[2]=$con->real_escape_string($_POST["expmonth"]); 	                  //string(2) "12"
			$P[3]=$con->real_escape_string($_POST["contact"]);  	                  //string(19) "אלעד שסקין"
			$P[4]=$con->real_escape_string($_POST["myid"]);     	                  //string(9) "015394265"
			$P[5]=$con->real_escape_string($_POST["currency"]);	                  //string(1) "1"
			$P[6]=$con->real_escape_string($_POST["email"]);    	                  //string(24) "fiveminutes001@gmail.com"
			$P[7]=$con->real_escape_string($_POST["city"]);     	                  //string(13) "תל אביב"
			$P[8]=$con->real_escape_string($_POST["expyear"]); 	                  //string(2) "21"
			$P[9]=$con->real_escape_string($_POST["supplier"]); 	                  //string(12) "ttxexplainit"
			$P[10]=$con->real_escape_string($_POST["npay"]);    	                  //string(1) "0"
			$P[11]=$con->real_escape_string($_POST["address"]);  	                  //string(22) "רחוב כלשהו 42"
			$P[12]=$con->real_escape_string($_POST["pdesc"]);    	                  //string(36) "הכנה לבגרות בפיזיקה"
			$P[13]=$con->real_escape_string($_POST["remarks"]);  	                  //string(20) "מה קורה וזה"
			$P[14]=$con->real_escape_string($_POST["company"]); 	                  //string(2) "xo"
			$P[15]=$con->real_escape_string($_POST["sum"]);      	                  //string(1) "5"
			$P[16]=$con->real_escape_string($_POST["fpay"]);     	                  //string(1) "0"
			$P[17]=$con->real_escape_string($_POST["xnpay"]);    	                  //string(1) "1"
			$P[18]=$con->real_escape_string($_POST["lang"]);     	                  //string(2) "il"
			$P[19]=$con->real_escape_string($_POST["spay"]);     	                  //string(1) "0"
			$P[20]=$con->real_escape_string($_POST["phone"]);    	                  //string(11) "050-8523270"
			$P[21]=$con->real_escape_string($_POST["ccno"]);     	                  //string(4) "6041"
			$P[22]=$con->real_escape_string($_POST["cred_type"]);	                  //string(1) "1"
			$P[23]=$con->real_escape_string($_POST["DclickTK"]);       	          //string(0) ""
			$P[24]=$con->real_escape_string($_POST["tranmode"]);       	          //string(0) ""
			$P[25]=$con->real_escape_string($_POST["g-recaptcha-response"]);        //string(462) "03ACgFB9teQ_DMEGM-HDx3nj7ZsSHwEVrcIKcUlPmATr_KAxR60Rt76lXslW51kfH2UL9m6LOWIZhxYJSJO1HgNcoHb8vOF7AnS57qOq0kVHG6EUvDp7HKPXso2gf2ZUoeEVzBfd4ohJTR631730lMblKt-enAzCNIV2DltvfAK76sWUHBNYNmbugiOd8SmYa8T20qkBnZDPptwXJ7GiQriEi65Qzy6YW5wV9aCOH3lQFh7_Pkr1Ddg1YtAhfH1H0GndkMpEMvNQkty0zmKEkET0nVejGTCkwn6Mb-djH-5vQykjWaY6Y3yomLrYBBq7SeNyebc180Ebx4T6U8ego1ziqRlCp5qsxZLJB4Bx6dJehkC_QOBfkHrYZI4-AGgQJyRYBFA-elzt4ljt2WiZ4lUIrgpOH9kNFKtJV_ANc93tOn3guF1MtUezZK8SsOZAd2nqfPTe-xNqew"
			$P[26]=$con->real_escape_string($_POST["ConfirmationCode"]);            //string(7) "0064018"
			$P[27]=$con->real_escape_string($_POST["index"]);                       //string(6) "465069"
			$P[28]=$con->real_escape_string($_POST["Responsesource"]);              //string(1) "2"
			$P[29]=$con->real_escape_string($_POST["Responsecvv"]);                 //string(1) "1"
			$P[30]=$con->real_escape_string($_POST["Responseid"]);                  //string(1) "3"
			$P[31]=$con->real_escape_string($_POST["Tempref"]);                     //string(8) "47110005"
			$P[32]=$con->real_escape_string($_POST["DBFIsForeign"]);                //string(1) "0"
			$P[33]=$con->real_escape_string($_POST["DBFcard"]);                     //string(1) "2"
			$P[34]=$con->real_escape_string($_POST["cardtype"]);                    //string(1) "2"
			$P[35]=$con->real_escape_string($_POST["DBFcardtype"]);                 //string(1) "6"
			$P[36]=$con->real_escape_string($_POST["cardissuer"]);                  //string(1) "6"
			$P[37]=$con->real_escape_string($_POST["DBFsolek"]);                    //string(1) "1"
			$P[38]=$con->real_escape_string($_POST["cardaquirer"]);                 //string(1) "1"
			$P[39]=$con->real_escape_string($_POST["tz_parent"]);                   //string(18) "tranzilaipsp10"
													
		//SANITIZING COOKIE VARS
			$C=array();                                   
			$C[0]=$con->real_escape_string($_COOKIE["_ga"]); 	         	          //string(25) "GA1.2.74162931.1500919288"
			$C[1]=$con->real_escape_string($_COOKIE["__distillery"]);               //string(72) "5e8d52b_7c1a81d5-d32e-447f-aadf-ec5b081b60a8-c4e78f13b-564a3972e7c6-1183"
			$C[2]=$con->real_escape_string($_COOKIE["__gads"]); 	                  //string(69) "ID=e4c99ba1eec7f6ce:T=1527021321:S=ALNI_MY87CBs3hLRG5G_G8hATRA1hJIeAg"
			$C[3]=$con->real_escape_string($_COOKIE["PHPSESSID"]);  	              //string(26) "oou0s9m1hnq39cvf2ginflni00"
			$C[4]=$con->real_escape_string($_COOKIE["_gid"]);     	              //string(27) "GA1.2.1201888855.1528003873"
													
		//SANITIZING FILES VARS                                       
			$F=array();                                   
			$F[0]=$con->real_escape_string(implode(" ",$_FILES)); 	         	          //string(25) "GA1.2.74162931.1500919288"
													
		//SANITIZING SERVER VARS                                    
			$SE=array();
			$SE[0]=$con->real_escape_string($_SERVER["CONTENT_LENGTH"]);   	     		     //string(4) "1356"
			$SE[1]=$con->real_escape_string($_SERVER["CONTENT_TYPE"]);   			 		 //string(33) "application/x-www-form-urlencoded"
			$SE[2]=$con->real_escape_string($_SERVER["CONTEXT_DOCUMENT_ROOT"]);     		 //string(26) "/home/elad189g/public_html"
			$SE[3]=$con->real_escape_string($_SERVER["CONTEXT_PREFIX"]);       	 		     //string(0) ""
			$SE[4]=$con->real_escape_string($_SERVER["DOCUMENT_ROOT"]);   			 		 //string(26) "/home/elad189g/public_html"
			$SE[5]=$con->real_escape_string($_SERVER["GATEWAY_INTERFACE"]);  		 		 //string(7) "CGI/1.1"
		//HTTPS ADDITION                                                                 
			$SE[6]=$con->real_escape_string($_SERVER["H2PUSH"]);    		     	     	 //string(2) "on"
			$SE[7]=$con->real_escape_string($_SERVER["H2_PUSH"]);      		                 //string(2) "on" 
			$SE[8]=$con->real_escape_string($_SERVER["H2_PUSHED"]);      		             //string(0) ""
			$SE[9]=$con->real_escape_string($_SERVER["H2_PUSHED_ON"]);        		         //string(0) ""
			$SE[10]=$con->real_escape_string($_SERVER["H2_STREAM_ID"]);          		     //string(1) "1"
			$SE[11]=$con->real_escape_string($_SERVER["H2_STREAM_TAG"]);              		 //string(5) "205-1"
			$SE[12]=$con->real_escape_string($_SERVER["HTTP2"]);   		     		         //string(2) "on"
			$SE[13]=$con->real_escape_string($_SERVER["HTTPS"]);              		         //string(2) "on"
					
			$SE[14]=$con->real_escape_string($_SERVER["HTTP_ACCEPT"]);    		     		 //string(85) "text/html,application/xhtml+xml,application/xml);q=0.9,image/webp,image/apng,*/*);q=0.8"
			$SE[15]=$con->real_escape_string($_SERVER["HTTP_ACCEPT_ENCODING"]);      		 //string(13) "gzip, deflate"
			$SE[16]=$con->real_escape_string($_SERVER["HTTP_ACCEPT_LANGUAGE"]);      		 //string(23) "en-US,en);q=0.9,la);q=0.8"
			$SE[17]=$con->real_escape_string($_SERVER["HTTP_CACHE_CONTROL"]);        		 //string(9) "max-age=0"
			
			$SE[18]=$con->real_escape_string($_SERVER["HTTP_COOKIE"]);              		 //string(266) "_ga=GA1.2.74162931.1500919288); __distillery=5e8d52b_7c1a81d5-d32e-447f-aadf-ec5b081b60a8-c4e78f13b-564a3972e7c6-1183); __gads=ID=e4c99ba1eec7f6ce:T=1527021321:S=ALNI_MY87CBs3hLRG5G_G8hATRA1hJIeAg); PHPSESSID=oou0s9m1hnq39cvf2ginflni00); _gid=GA1.2.1201888855.1528003873"
			$SE[19]=$con->real_escape_string($_SERVER["HTTP_HOST"]);   		     		     //string(20) "www.explainit.online"
			$SE[20]=$con->real_escape_string($_SERVER["HTTP_ORIGIN"]);              		 //string(4) "null"
			$SE[21]=$con->real_escape_string($_SERVER["HTTP_REFERER"]);              		 //string(4) "https://direct.tranzila.com/process/?cc"
			$SE[22]=$con->real_escape_string($_SERVER["HTTP_UPGRADE_INSECURE_REQUESTS"]);    //string(1) "1"
			$SE[23]=$con->real_escape_string($_SERVER["HTTP_USER_AGENT"]);                   //string(115) "Mozilla/5.0 (Windows NT 10.0); Win64); x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
			$SE[24]=$con->real_escape_string($_SERVER["HTTP_X_HTTPS"]);                      //string(1) "1"
			$SE[25]=$con->real_escape_string($_SERVER["PATH"]);   							 //string(13) "/bin:/usr/bin"
			$SE[26]=$con->real_escape_string($_SERVER["QUERY_STRING"]);                      //string(0) ""
			$SE[27]=$con->real_escape_string($_SERVER["REDIRECT_STATUS"]);                   //string(3) "200"
			$SE[28]=$con->real_escape_string($_SERVER["REMOTE_ADDR"]);                       //string(14) "85.250.146.223"
			$SE[29]=$con->real_escape_string($_SERVER["REMOTE_PORT"]);                       //string(5) "65176"
			$SE[30]=$con->real_escape_string($_SERVER["REQUEST_METHOD"]);                    //string(4) "POST"
			$SE[31]=$con->real_escape_string($_SERVER["REQUEST_SCHEME"]);                    //string(4) "http"
			$SE[32]=$con->real_escape_string($_SERVER["REQUEST_URI"]);                       //string(33) "/s1/s8_videos/payment/success.php"
			$SE[33]=$con->real_escape_string($_SERVER["SCRIPT_FILENAME"]);                   //string(59) "/home/elad189g/public_html/s1/s8_videos/payment/success.php"
			$SE[34]=$con->real_escape_string($_SERVER["SCRIPT_NAME"]);                       //string(33) "/s1/s8_videos/payment/success.php"
			$SE[35]=$con->real_escape_string($_SERVER["SCRIPT_URI"]);                        //string(60) "http://www.explainit.online/s1/s8_videos/payment/success.php"
			$SE[36]=$con->real_escape_string($_SERVER["SCRIPT_URL"]);                        //string(33) "/s1/s8_videos/payment/success.php"
			$SE[37]=$con->real_escape_string($_SERVER["SERVER_ADDR"]);                       //string(14) "67.228.104.238"
			$SE[38]=$con->real_escape_string($_SERVER["SERVER_ADMIN"]);                      //string(26) "webmaster@explainit.online"
			$SE[39]=$con->real_escape_string($_SERVER["SERVER_NAME"]);                       //string(20) "www.explainit.online"
			$SE[40]=$con->real_escape_string($_SERVER["SERVER_PORT"]);                       //string(2) "80"
			$SE[41]=$con->real_escape_string($_SERVER["SERVER_PROTOCOL"]);                   //string(8) "HTTP/1.1"
			$SE[42]=$con->real_escape_string($_SERVER["SERVER_SIGNATURE"]);                  //string(0) ""
			$SE[43]=$con->real_escape_string($_SERVER["SERVER_SOFTWARE"]);                   //string(6) "Apache"
			$SE[44]=$con->real_escape_string($_SERVER["SSL_TLS_SNI"]);                       //string(20) "www.explainit.online"
			$SE[45]=$con->real_escape_string($_SERVER["UNIQUE_ID"]);                         //string(27) "WxOKwKlQn8JWKy0-mL7aKwAAAA0"
			$SE[46]=$con->real_escape_string($_SERVER["PHP_SELF"]);                          //string(33) "/s1/s8_videos/payment/success.php"
			$SE[47]=$con->real_escape_string($_SERVER["REQUEST_TIME_FLOAT"]);                //float(1528007360.5745)
			$SE[48]=$con->real_escape_string($_SERVER["REQUEST_TIME"]);                      //int(1528007360)
			
			//SESSION//SESSION ARRAY EMPTY                                     
			if (empty($_SESSION))
			{
				$S=array();
				$S[0]='7';	
				$S[1]='7';
				$S[2]='7';
				$S[3]='7';
				$S[4]='7';
				$S[5]='7';
				$S[6]='7';
				$S[7]='7';
				$S[8]='7';
				$S[9]='7';
			}//SESSION ARRAY EMPTY
	/*			
			//SESSION ARRAY ISN'T EMPTY
			else
			{
				$S=array();
				$S[0]=trim(strip_tags($_SESSION["message_1"]));        		 // string(220) "מיד תועבר לדף התשלום. חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא"ל"
				$S[1]=$_SESSION["loggedin"];   	     		   	                                 // int(1)
				$S[2]=$_SESSION["count"];   			 		   	                             // int(1)
				$S[3]=$_SESSION["u_n"];     		               	                             // string(14) "85.250.146.223"
				$S[4]=$_SESSION["u_name"];       	 		   	                                 // string(24) "fiveminutes001@gmail.com"
				$S[5]=$_SESSION["timestamp"];   			 	   	                             // string(15) "1528115144.6599"
				$S[6]=$_SESSION["dir_01"];  		 		       	                             // string(17) "2018-06-03-005044"
				$S[7]=$_SESSION["directory"];    		       	                                 // string(33) "2018-06-03-005044-1528115144.6599"
				$S[8]=$_SESSION["example"];      		       	                                 // int(1)
				$S[9]=$_SESSION["paid"];      		           	                                 // string(1) "N"
			}//SESSION ARRAY ISN'T EMPTY
	*/			
			// QUERIES
			//DATABASE//CONNECTING//DATA
			//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
			//*include "../php/test_fi/test_po_7.php";
			
			//GET DB DETAILS
			$new_path = 'test_02';
			$db_details = getfile($new_path,12);
			
			//CONNECTING//DATABASE//DATA
		
			$host = $db_details[0];
			$username = $db_details[1];
			$password = $db_details[2];
			$db = $db_details[3];
	
			//CREATING CONNECTION
			$con = mysqli_connect($host, $username, $password,$db);
			
			//CHECKING CONNECTION
			if($con)
			{
				//echo 'connection ok';
			}
			else
			{
				die('Could not connect: '.mysqli_error($con));
			}
				
			//SELECTING DATABASE
			mysqli_select_db($con, $db_details[3]); 
			
			//ENABLING HEBREW
			mysqli_query($con,"SET character_set_client=utf8mb4");
			mysqli_query($con,"SET character_set_connection=utf8mb4");
			mysqli_query($con,"SET character_set_database=utf8mb4");
			mysqli_query($con,"SET character_set_results=utf8mb4");
			mysqli_query($con,"SET character_set_server=utf8mb4");
			
			//SETTING TIME
			$sql_Time = "SET time_zone = '+03:00';";
			$query = mysqli_query($con,$sql_Time);
			
			//TIME
			$d=time();
			
			//QUERIES	
				//QUERY CODE
			$sql ="INSERT INTO Pay_today (`Name`, `TIME_STAMP`, `Payed`,`BY_MAIL`,`ConfirmationCode`,`Card_number`,`Exp_month`,`Exp_year`,`City`) VALUES ('$P[3]', '$d', 'Y','$P[6]','$P[26]','$P[21]','$P[2]','$P[8]','$P[7]')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY POST
			$sql ="INSERT INTO Pay_today_POST (`Response`, `ipsp`, `expmonth`, `contact`, `myid`, `currency`, `email`, `city`, `expyear`, `supplier`, `npay`, `address`, `pdesc`, `remarks`, `company`, `sum`, `fpay`, `xnpay`, `lang`, `spay`, `phone`, `ccno`, `cred_type`, `DclickTK`, `tranmode`, `g-recaptcha-response`, `ConfirmationCode`, `index_1`, `Responsesource`, `Responsecvv`, `Responseid`, `Tempref`, `DBFIsForeign`, `DBFcard`, `cardtype`, `DBFcardtype`, `cardissuer`, `DBFsolek`, `cardaquirer`, `tz_parent`, `TIME_STAMP`) VALUES ('$P[0]', '$P[1]', '$P[2]', '$P[3]', '$P[4]', '$P[5]', '$P[6]', '$P[7]', '$P[8]', '$P[9]', '$P[10]', '$P[11]', '$P[12]', '$P[13]', '$P[14]', '$P[15]', '$P[16]', '$P[17]', '$P[18]', '$P[19]', '$P[20]', '$P[21]', '$P[22]', '$P[23]', '$P[24]', '$P[25]', '$P[26]', '$P[27]', '$P[28]', '$P[29]', '$P[30]', '$P[31]', '$P[32]', '$P[33]', '$P[34]', '$P[35]', '$P[36]', '$P[37]', '$P[38]', '$P[39]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY COOKIE
			$sql = "INSERT INTO Pay_today_COOKIE (_ga,__distillery,	__gads,PHPSESSID,_gid, TIME_STAMP) VALUES ('$C[0]','$C[1]','$C[2]','$C[3]','$C[4]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY FILES
			$sql = "INSERT INTO Pay_today_FILES (Files, TIME_STAMP) VALUES ('$F[0]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY SERVER
			$sql = "INSERT INTO Pay_today_SERVER (`CONTENT_LENGTH`, `CONTENT_TYPE`, `CONTEXT_DOCUMENT_ROOT`, `CONTEXT_PREFIX`, `DOCUMENT_ROOT`, `GATEWAY_INTERFACE`, `H2PUSH`, `H2_PUSH`, `H2_PUSHED`, `H2_PUSHED_ON`, `H2_STREAM_ID`, `H2_STREAM_TAG`, `HTTP2`, `HTTPS`, `HTTP_ACCEPT`, `HTTP_ACCEPT_ENCODING`, `HTTP_ACCEPT_LANGUAGE`, `HTTP_CACHE_CONTROL`, `HTTP_COOKIE`, `HTTP_HOST`, `HTTP_ORIGIN`, `HTTP_REFERER`, `HTTP_UPGRADE_INSECURE_REQUESTS`, `HTTP_USER_AGENT`, `HTTP_X_HTTPS`, `PATH`, `QUERY_STRING`, `REDIRECT_STATUS`, `REMOTE_ADDR`, `REMOTE_PORT`, `REQUEST_METHOD`, `REQUEST_SCHEME`, `REQUEST_URI`, `SCRIPT_FILENAME`, `SCRIPT_NAME`, `SCRIPT_URI`, `SCRIPT_URL`, `SERVER_ADDR`, `SERVER_ADMIN`, `SERVER_NAME`, `SERVER_PORT`, `SERVER_PROTOCOL`, `SERVER_SIGNATURE`, `SERVER_SOFTWARE`, `SSL_TLS_SNI`, `UNIQUE_ID`, `PHP_SELF`, `REQUEST_TIME_FLOAT`, `REQUEST_TIME`,`TIME_STAMP`) VALUES ('$SE[0]', '$SE[1]', '$SE[2]', '$SE[3]', '$SE[4]', '$SE[5]', '$SE[6]', '$SE[7]', '$SE[8]', '$SE[9]', '$SE[10]', '$SE[11]', '$SE[12]', '$SE[13]', '$SE[14]', '$SE[15]', '$SE[16]', '$SE[17]', '$SE[18]', '$SE[19]', '$SE[20]', '$SE[21]', '$SE[22]', '$SE[23]', '$SE[24]', '$SE[25]', '$SE[26]', '$SE[27]', '$SE[28]', '$SE[29]', '$SE[30]', '$SE[31]', '$SE[32]', '$SE[33]', '$SE[34]', '$SE[35]', '$SE[36]', '$SE[37]', '$SE[38]','$SE[39]','$SE[40]','$SE[41]','$SE[42]','$SE[43]','$SE[44]','$SE[45]','$SE[46]','$SE[47]','$SE[48]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
						
			if(isset($_SESSION["refresh_count"]) && $_SESSION["refresh_count"] < 3)
			{
				//MAIL//CONFIRMATION MAIL//OUTPUT 03
				//ATTRIBUTES
				$t=$P[6];
				$s="Explainit Online - קורס 003 - אישור תשלום";
				
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;direction:rtl;">';
				$message .= '<h4>הי,</h4><h4>המייל הזה מאשר ששילמת 80 ש"ח עבור מנוי לקורס 003 - "מלכים ונביאים – ממלכות מנשה עד חורבן ממלכת יהודה" של ד"ר בועז סתוי. המנוי לתמיד.
				</h4><h4>מספר אישור '.$P[26].'.</h4><h4> קבלה תישלח תוך 24 שעות.</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($t,$s, $message, $headers);
						
				//REPORT COPY TO XO
				$t="registration@explainit.online";
				$s="Explainit Online - קורס 003 - אישור תשלום";
				
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;direction:rtl;">';
				$message .= '<h4>הי,</h4><h4>המייל הזה מאשר ששילמת 80 ש"ח עבור מנוי לקורס 003 - "מלכים ונביאים – ממלכות מנשה עד חורבן ממלכת יהודה" של ד"ר בועז סתוי. המנוי לתמיד.
				</h4><h4>מספר אישור '.$P[26].'.</h4><h4> קבלה תישלח תוך 24 שעות.</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($t,$s, $message, $headers);
								
				//REPORT MAIL TO LECTURER
				//ATTRIBUTES
				$f="boazstavi@gmail.com";
				$f_1="Explainit Online - קורס 003 - לקוח/ה חדש/ה";
				
				//HEADERS
				$headers = "From: registration@explainit.online\r\n";
				$headers .= "Reply-To:registration@explainit.online\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
				
				//MESSAGE
				$message = '<html lang="iw" dir="rtl"><body>';
				$message .= '<div style="width:100%;margin:auto;text-align:center;">';
				$message .= '<h4>מספר אישור:</h4>';
				$message .= '<h4>'.$P[26].'</h4>';
				$message .= "</div>";
				$message .= "</body></html>";
				
				//SENDING
				mail($f,$f_1,$message,$headers);
				
				echo '<script>setTimeout(function(){document.getElementById("a_1").click();}, 2000);</script>';
				
				// SLEEPING
				//sleep(2);
			}//REFRESH COUNT < 3
		
		//REPORT MAIL TO XO//ATTRIBUTES
			$f="registration@explainit.online";
			$f_1="Explainit Online - קורס 003 - לקוח/ה חדש/ה";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$t.'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
			
			//REFRESH COUNT UPDATE
			$_SESSION["refresh_count"]++;
				
		}
		else//REFERER ISN'T DIRECT
		{
			//REPORT MAIL TO XO//ATTRIBUTES//OUTPUT 04
			$f="registration@explainit.online";
			$f_1="Explainit Online - קורס 003 - SUCCESS - REFERER NOT TRANZILLA";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$P[6].'</h4>';
			$message .= '<h4>IP:</h4>';
			$message .= '<h4>'.$_SERVER["REMOTE_ADDR"].'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
				
			//ERROR PAGE//OUTPUT 05
			header ('location: ../php/error_fi/error_videos_8.php');
		}//REFERER ISN'T DIRECT
	}
	else//METHOD NOT POST
	{
		//REPORT MAIL TO XO//ATTRIBUTES//OUTPUT 04
			$f="registration@explainit.online";
			$f_1="Explainit Online - קורס 003 - SUCCESS - METHOD NOT POST";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$P[6].'</h4>';
			$message .= '<h4>IP:</h4>';
			$message .= '<h4>'.$_SERVER["REMOTE_ADDR"].'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
		
		//ERROR PAGE//OUTPUT 06
		header ('location: ../php/error_fi/error_videos_8.php');
	}
}//$_SESSION["refresh_count"] is set and < 3

//$_SESSION["refresh_count"] is > 3, silent update
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{	
		// CHECKING REFERER
		//if($_SERVER["HTTP_REFERER"] == "https://direct.tranzila.com/process/?cc") 
		if(strpos($_SERVER["HTTP_REFERER"], 'https://direct.tranzila.com/process') !== false)
		{
			//DATABASE//CONNECTING//DATA
			//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
			include "../php/test_fi/test_po_7.php";
				
			//GET DB DETAILS
			$new_path = 'test_01';
			$db_details = getfile($new_path,12);
				
			//CONNECTING//DATABASE//DATA
			
			$host = $db_details[0];
			$username = $db_details[1];
			$password = $db_details[2];
			$db = $db_details[3];
			
			//CREATING CONNECTION
			$con = mysqli_connect($host, $username, $password,$db);
			
			//CHECKING CONNECTION
			if($con)
			{
				//echo '<i class="fa fa-check-square-o" style="font-size:24px;color:purple;"></i>';
				//echo 'connection ok';
			}
			else
			{
				die('Could not connect: ' . mysqli_error($con));
			}
				
			//SELECTING DATABASE
			mysqli_select_db($con, $db_details[3]); 
			
			//ENABLING HEBREW
			mysqli_query($con,"SET character_set_client=utf8mb4");
			mysqli_query($con,"SET character_set_connection=utf8mb4");
			mysqli_query($con,"SET character_set_database=utf8mb4");
			mysqli_query($con,"SET character_set_results=utf8mb4");
			mysqli_query($con,"SET character_set_server=utf8mb4");
			
			//SETTING TIME	
			$sql_Time = "SET time_zone = '+03:00';";
			$query = mysqli_query($con,$sql_Time);
		
		//SANITIZING POST VARS
			$P=array();
			$P[0]=$con->real_escape_string($_POST["Response"]); 	                  //string(3) "000"
			$P[1]=$con->real_escape_string($_POST["ipsp"]);     	                  //string(1) "1"
			$P[2]=$con->real_escape_string($_POST["expmonth"]); 	                  //string(2) "12"
			$P[3]=$con->real_escape_string($_POST["contact"]);  	                  //string(19) "אלעד שסקין"
			$P[4]=$con->real_escape_string($_POST["myid"]);     	                  //string(9) "015394265"
			$P[5]=$con->real_escape_string($_POST["currency"]);	                  //string(1) "1"
			$P[6]=$con->real_escape_string($_POST["email"]);    	                  //string(24) "fiveminutes001@gmail.com"
			$P[7]=$con->real_escape_string($_POST["city"]);     	                  //string(13) "תל אביב"
			$P[8]=$con->real_escape_string($_POST["expyear"]); 	                  //string(2) "21"
			$P[9]=$con->real_escape_string($_POST["supplier"]); 	                  //string(12) "ttxexplainit"
			$P[10]=$con->real_escape_string($_POST["npay"]);    	                  //string(1) "0"
			$P[11]=$con->real_escape_string($_POST["address"]);  	                  //string(22) "רחוב כלשהו 42"
			$P[12]=$con->real_escape_string($_POST["pdesc"]);    	                  //string(36) "הכנה לבגרות בפיזיקה"
			$P[13]=$con->real_escape_string($_POST["remarks"]);  	                  //string(20) "מה קורה וזה"
			$P[14]=$con->real_escape_string($_POST["company"]); 	                  //string(2) "xo"
			$P[15]=$con->real_escape_string($_POST["sum"]);      	                  //string(1) "5"
			$P[16]=$con->real_escape_string($_POST["fpay"]);     	                  //string(1) "0"
			$P[17]=$con->real_escape_string($_POST["xnpay"]);    	                  //string(1) "1"
			$P[18]=$con->real_escape_string($_POST["lang"]);     	                  //string(2) "il"
			$P[19]=$con->real_escape_string($_POST["spay"]);     	                  //string(1) "0"
			$P[20]=$con->real_escape_string($_POST["phone"]);    	                  //string(11) "050-8523270"
			$P[21]=$con->real_escape_string($_POST["ccno"]);     	                  //string(4) "6041"
			$P[22]=$con->real_escape_string($_POST["cred_type"]);	                  //string(1) "1"
			$P[23]=$con->real_escape_string($_POST["DclickTK"]);       	          //string(0) ""
			$P[24]=$con->real_escape_string($_POST["tranmode"]);       	          //string(0) ""
			$P[25]=$con->real_escape_string($_POST["g-recaptcha-response"]);        //string(462) "03ACgFB9teQ_DMEGM-HDx3nj7ZsSHwEVrcIKcUlPmATr_KAxR60Rt76lXslW51kfH2UL9m6LOWIZhxYJSJO1HgNcoHb8vOF7AnS57qOq0kVHG6EUvDp7HKPXso2gf2ZUoeEVzBfd4ohJTR631730lMblKt-enAzCNIV2DltvfAK76sWUHBNYNmbugiOd8SmYa8T20qkBnZDPptwXJ7GiQriEi65Qzy6YW5wV9aCOH3lQFh7_Pkr1Ddg1YtAhfH1H0GndkMpEMvNQkty0zmKEkET0nVejGTCkwn6Mb-djH-5vQykjWaY6Y3yomLrYBBq7SeNyebc180Ebx4T6U8ego1ziqRlCp5qsxZLJB4Bx6dJehkC_QOBfkHrYZI4-AGgQJyRYBFA-elzt4ljt2WiZ4lUIrgpOH9kNFKtJV_ANc93tOn3guF1MtUezZK8SsOZAd2nqfPTe-xNqew"
			$P[26]=$con->real_escape_string($_POST["ConfirmationCode"]);            //string(7) "0064018"
			$P[27]=$con->real_escape_string($_POST["index"]);                       //string(6) "465069"
			$P[28]=$con->real_escape_string($_POST["Responsesource"]);              //string(1) "2"
			$P[29]=$con->real_escape_string($_POST["Responsecvv"]);                 //string(1) "1"
			$P[30]=$con->real_escape_string($_POST["Responseid"]);                  //string(1) "3"
			$P[31]=$con->real_escape_string($_POST["Tempref"]);                     //string(8) "47110005"
			$P[32]=$con->real_escape_string($_POST["DBFIsForeign"]);                //string(1) "0"
			$P[33]=$con->real_escape_string($_POST["DBFcard"]);                     //string(1) "2"
			$P[34]=$con->real_escape_string($_POST["cardtype"]);                    //string(1) "2"
			$P[35]=$con->real_escape_string($_POST["DBFcardtype"]);                 //string(1) "6"
			$P[36]=$con->real_escape_string($_POST["cardissuer"]);                  //string(1) "6"
			$P[37]=$con->real_escape_string($_POST["DBFsolek"]);                    //string(1) "1"
			$P[38]=$con->real_escape_string($_POST["cardaquirer"]);                 //string(1) "1"
			$P[39]=$con->real_escape_string($_POST["tz_parent"]);                   //string(18) "tranzilaipsp10"
													
		//SANITIZING COOKIE VARS
			$C=array();                                   
			$C[0]=$con->real_escape_string($_COOKIE["_ga"]); 	         	          //string(25) "GA1.2.74162931.1500919288"
			$C[1]=$con->real_escape_string($_COOKIE["__distillery"]);               //string(72) "5e8d52b_7c1a81d5-d32e-447f-aadf-ec5b081b60a8-c4e78f13b-564a3972e7c6-1183"
			$C[2]=$con->real_escape_string($_COOKIE["__gads"]); 	                  //string(69) "ID=e4c99ba1eec7f6ce:T=1527021321:S=ALNI_MY87CBs3hLRG5G_G8hATRA1hJIeAg"
			$C[3]=$con->real_escape_string($_COOKIE["PHPSESSID"]);  	              //string(26) "oou0s9m1hnq39cvf2ginflni00"
			$C[4]=$con->real_escape_string($_COOKIE["_gid"]);     	              //string(27) "GA1.2.1201888855.1528003873"
													
		//SANITIZING FILES VARS                                       
			$F=array();                                   
			$F[0]=$con->real_escape_string(implode(" ",$_FILES)); 	         	          //string(25) "GA1.2.74162931.1500919288"
													
		//SANITIZING SERVER VARS                                    
			$SE=array();
			$SE[0]=$con->real_escape_string($_SERVER["CONTENT_LENGTH"]);   	     		     //string(4) "1356"
			$SE[1]=$con->real_escape_string($_SERVER["CONTENT_TYPE"]);   			 		 //string(33) "application/x-www-form-urlencoded"
			$SE[2]=$con->real_escape_string($_SERVER["CONTEXT_DOCUMENT_ROOT"]);     		 //string(26) "/home/elad189g/public_html"
			$SE[3]=$con->real_escape_string($_SERVER["CONTEXT_PREFIX"]);       	 		     //string(0) ""
			$SE[4]=$con->real_escape_string($_SERVER["DOCUMENT_ROOT"]);   			 		 //string(26) "/home/elad189g/public_html"
			$SE[5]=$con->real_escape_string($_SERVER["GATEWAY_INTERFACE"]);  		 		 //string(7) "CGI/1.1"
		//HTTPS ADDITION                                                                 
			$SE[6]=$con->real_escape_string($_SERVER["H2PUSH"]);    		     	     	 //string(2) "on"
			$SE[7]=$con->real_escape_string($_SERVER["H2_PUSH"]);      		                 //string(2) "on" 
			$SE[8]=$con->real_escape_string($_SERVER["H2_PUSHED"]);      		             //string(0) ""
			$SE[9]=$con->real_escape_string($_SERVER["H2_PUSHED_ON"]);        		         //string(0) ""
			$SE[10]=$con->real_escape_string($_SERVER["H2_STREAM_ID"]);          		     //string(1) "1"
			$SE[11]=$con->real_escape_string($_SERVER["H2_STREAM_TAG"]);              		 //string(5) "205-1"
			$SE[12]=$con->real_escape_string($_SERVER["HTTP2"]);   		     		         //string(2) "on"
			$SE[13]=$con->real_escape_string($_SERVER["HTTPS"]);              		         //string(2) "on"
					
			$SE[14]=$con->real_escape_string($_SERVER["HTTP_ACCEPT"]);    		     		 //string(85) "text/html,application/xhtml+xml,application/xml);q=0.9,image/webp,image/apng,*/*);q=0.8"
			$SE[15]=$con->real_escape_string($_SERVER["HTTP_ACCEPT_ENCODING"]);      		 //string(13) "gzip, deflate"
			$SE[16]=$con->real_escape_string($_SERVER["HTTP_ACCEPT_LANGUAGE"]);      		 //string(23) "en-US,en);q=0.9,la);q=0.8"
			$SE[17]=$con->real_escape_string($_SERVER["HTTP_CACHE_CONTROL"]);        		 //string(9) "max-age=0"
			
			$SE[18]=$con->real_escape_string($_SERVER["HTTP_COOKIE"]);              		 //string(266) "_ga=GA1.2.74162931.1500919288); __distillery=5e8d52b_7c1a81d5-d32e-447f-aadf-ec5b081b60a8-c4e78f13b-564a3972e7c6-1183); __gads=ID=e4c99ba1eec7f6ce:T=1527021321:S=ALNI_MY87CBs3hLRG5G_G8hATRA1hJIeAg); PHPSESSID=oou0s9m1hnq39cvf2ginflni00); _gid=GA1.2.1201888855.1528003873"
			$SE[19]=$con->real_escape_string($_SERVER["HTTP_HOST"]);   		     		     //string(20) "www.explainit.online"
			$SE[20]=$con->real_escape_string($_SERVER["HTTP_ORIGIN"]);              		 //string(4) "null"
			$SE[21]=$con->real_escape_string($_SERVER["HTTP_REFERER"]);              		 //string(4) "https://direct.tranzila.com/process/?cc"
			$SE[22]=$con->real_escape_string($_SERVER["HTTP_UPGRADE_INSECURE_REQUESTS"]);    //string(1) "1"
			$SE[23]=$con->real_escape_string($_SERVER["HTTP_USER_AGENT"]);                   //string(115) "Mozilla/5.0 (Windows NT 10.0); Win64); x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
			$SE[24]=$con->real_escape_string($_SERVER["HTTP_X_HTTPS"]);                      //string(1) "1"
			$SE[25]=$con->real_escape_string($_SERVER["PATH"]);   							 //string(13) "/bin:/usr/bin"
			$SE[26]=$con->real_escape_string($_SERVER["QUERY_STRING"]);                      //string(0) ""
			$SE[27]=$con->real_escape_string($_SERVER["REDIRECT_STATUS"]);                   //string(3) "200"
			$SE[28]=$con->real_escape_string($_SERVER["REMOTE_ADDR"]);                       //string(14) "85.250.146.223"
			$SE[29]=$con->real_escape_string($_SERVER["REMOTE_PORT"]);                       //string(5) "65176"
			$SE[30]=$con->real_escape_string($_SERVER["REQUEST_METHOD"]);                    //string(4) "POST"
			$SE[31]=$con->real_escape_string($_SERVER["REQUEST_SCHEME"]);                    //string(4) "http"
			$SE[32]=$con->real_escape_string($_SERVER["REQUEST_URI"]);                       //string(33) "/s1/s8_videos/payment/success.php"
			$SE[33]=$con->real_escape_string($_SERVER["SCRIPT_FILENAME"]);                   //string(59) "/home/elad189g/public_html/s1/s8_videos/payment/success.php"
			$SE[34]=$con->real_escape_string($_SERVER["SCRIPT_NAME"]);                       //string(33) "/s1/s8_videos/payment/success.php"
			$SE[35]=$con->real_escape_string($_SERVER["SCRIPT_URI"]);                        //string(60) "http://www.explainit.online/s1/s8_videos/payment/success.php"
			$SE[36]=$con->real_escape_string($_SERVER["SCRIPT_URL"]);                        //string(33) "/s1/s8_videos/payment/success.php"
			$SE[37]=$con->real_escape_string($_SERVER["SERVER_ADDR"]);                       //string(14) "67.228.104.238"
			$SE[38]=$con->real_escape_string($_SERVER["SERVER_ADMIN"]);                      //string(26) "webmaster@explainit.online"
			$SE[39]=$con->real_escape_string($_SERVER["SERVER_NAME"]);                       //string(20) "www.explainit.online"
			$SE[40]=$con->real_escape_string($_SERVER["SERVER_PORT"]);                       //string(2) "80"
			$SE[41]=$con->real_escape_string($_SERVER["SERVER_PROTOCOL"]);                   //string(8) "HTTP/1.1"
			$SE[42]=$con->real_escape_string($_SERVER["SERVER_SIGNATURE"]);                  //string(0) ""
			$SE[43]=$con->real_escape_string($_SERVER["SERVER_SOFTWARE"]);                   //string(6) "Apache"
			$SE[44]=$con->real_escape_string($_SERVER["SSL_TLS_SNI"]);                       //string(20) "www.explainit.online"
			$SE[45]=$con->real_escape_string($_SERVER["UNIQUE_ID"]);                         //string(27) "WxOKwKlQn8JWKy0-mL7aKwAAAA0"
			$SE[46]=$con->real_escape_string($_SERVER["PHP_SELF"]);                          //string(33) "/s1/s8_videos/payment/success.php"
			$SE[47]=$con->real_escape_string($_SERVER["REQUEST_TIME_FLOAT"]);                //float(1528007360.5745)
			$SE[48]=$con->real_escape_string($_SERVER["REQUEST_TIME"]);                      //int(1528007360)
			
			//SESSION//SESSION ARRAY EMPTY                                     
			if (empty($_SESSION))
			{
				$S=array();
				$S[0]='7';	
				$S[1]='7';
				$S[2]='7';
				$S[3]='7';
				$S[4]='7';
				$S[5]='7';
				$S[6]='7';
				$S[7]='7';
				$S[8]='7';
				$S[9]='7';
			}//SESSION ARRAY EMPTY
	/*			
			//SESSION ARRAY ISN'T EMPTY
			else
			{
				$S=array();
				$S[0]=trim(strip_tags($_SESSION["message_1"]));        		 // string(220) "מיד תועבר לדף התשלום. חשוב להכניס את המייל שאיתו נרשמת איפה שמבקשים להכניס דוא"ל"
				$S[1]=$_SESSION["loggedin"];   	     		   	                                 // int(1)
				$S[2]=$_SESSION["count"];   			 		   	                             // int(1)
				$S[3]=$_SESSION["u_n"];     		               	                             // string(14) "85.250.146.223"
				$S[4]=$_SESSION["u_name"];       	 		   	                                 // string(24) "fiveminutes001@gmail.com"
				$S[5]=$_SESSION["timestamp"];   			 	   	                             // string(15) "1528115144.6599"
				$S[6]=$_SESSION["dir_01"];  		 		       	                             // string(17) "2018-06-03-005044"
				$S[7]=$_SESSION["directory"];    		       	                                 // string(33) "2018-06-03-005044-1528115144.6599"
				$S[8]=$_SESSION["example"];      		       	                                 // int(1)
				$S[9]=$_SESSION["paid"];      		           	                                 // string(1) "N"
			}//SESSION ARRAY ISN'T EMPTY
	*/			
			// QUERIES
			//DATABASE//CONNECTING//DATA
			//GET FUNCTION TO GET DB DETAILS FROM FAR FILE//OUTPUT 00
			//*include "../php/test_fi/test_po_7.php";
			
			//GET DB DETAILS
			$new_path = 'test_02';
			$db_details = getfile($new_path,12);
			
			//CONNECTING//DATABASE//DATA
		
			$host = $db_details[0];
			$username = $db_details[1];
			$password = $db_details[2];
			$db = $db_details[3];
	
			//CREATING CONNECTION
			$con = mysqli_connect($host, $username, $password,$db);
			
			//CHECKING CONNECTION
			if($con)
			{
				//echo 'connection ok';
			}
			else
			{
				die('Could not connect: '.mysqli_error($con));
			}
				
			//SELECTING DATABASE
			mysqli_select_db($con, $db_details[3]); 
			
			//ENABLING HEBREW
			mysqli_query($con,"SET character_set_client=utf8mb4");
			mysqli_query($con,"SET character_set_connection=utf8mb4");
			mysqli_query($con,"SET character_set_database=utf8mb4");
			mysqli_query($con,"SET character_set_results=utf8mb4");
			mysqli_query($con,"SET character_set_server=utf8mb4");
			
			//SETTING TIME
			$sql_Time = "SET time_zone = '+03:00';";
			$query = mysqli_query($con,$sql_Time);
			
			//TIME
			$d=time();
			
			//QUERIES	
				//QUERY CODE
			$sql ="INSERT INTO Pay_today (`Name`, `TIME_STAMP`, `Payed`,`BY_MAIL`,`ConfirmationCode`,`Card_number`,`Exp_month`,`Exp_year`,`City`) VALUES ('$P[3]', '$d', 'Y','$P[6]','$P[26]','$P[21]','$P[2]','$P[8]','$P[7]')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY POST
			$sql ="INSERT INTO Pay_today_POST (`Response`, `ipsp`, `expmonth`, `contact`, `myid`, `currency`, `email`, `city`, `expyear`, `supplier`, `npay`, `address`, `pdesc`, `remarks`, `company`, `sum`, `fpay`, `xnpay`, `lang`, `spay`, `phone`, `ccno`, `cred_type`, `DclickTK`, `tranmode`, `g-recaptcha-response`, `ConfirmationCode`, `index_1`, `Responsesource`, `Responsecvv`, `Responseid`, `Tempref`, `DBFIsForeign`, `DBFcard`, `cardtype`, `DBFcardtype`, `cardissuer`, `DBFsolek`, `cardaquirer`, `tz_parent`, `TIME_STAMP`) VALUES ('$P[0]', '$P[1]', '$P[2]', '$P[3]', '$P[4]', '$P[5]', '$P[6]', '$P[7]', '$P[8]', '$P[9]', '$P[10]', '$P[11]', '$P[12]', '$P[13]', '$P[14]', '$P[15]', '$P[16]', '$P[17]', '$P[18]', '$P[19]', '$P[20]', '$P[21]', '$P[22]', '$P[23]', '$P[24]', '$P[25]', '$P[26]', '$P[27]', '$P[28]', '$P[29]', '$P[30]', '$P[31]', '$P[32]', '$P[33]', '$P[34]', '$P[35]', '$P[36]', '$P[37]', '$P[38]', '$P[39]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY COOKIE
			$sql = "INSERT INTO Pay_today_COOKIE (_ga,__distillery,	__gads,PHPSESSID,_gid, TIME_STAMP) VALUES ('$C[0]','$C[1]','$C[2]','$C[3]','$C[4]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY FILES
			$sql = "INSERT INTO Pay_today_FILES (Files, TIME_STAMP) VALUES ('$F[0]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
			
			//QUERY SERVER
			$sql = "INSERT INTO Pay_today_SERVER (`CONTENT_LENGTH`, `CONTENT_TYPE`, `CONTEXT_DOCUMENT_ROOT`, `CONTEXT_PREFIX`, `DOCUMENT_ROOT`, `GATEWAY_INTERFACE`, `H2PUSH`, `H2_PUSH`, `H2_PUSHED`, `H2_PUSHED_ON`, `H2_STREAM_ID`, `H2_STREAM_TAG`, `HTTP2`, `HTTPS`, `HTTP_ACCEPT`, `HTTP_ACCEPT_ENCODING`, `HTTP_ACCEPT_LANGUAGE`, `HTTP_CACHE_CONTROL`, `HTTP_COOKIE`, `HTTP_HOST`, `HTTP_ORIGIN`, `HTTP_REFERER`, `HTTP_UPGRADE_INSECURE_REQUESTS`, `HTTP_USER_AGENT`, `HTTP_X_HTTPS`, `PATH`, `QUERY_STRING`, `REDIRECT_STATUS`, `REMOTE_ADDR`, `REMOTE_PORT`, `REQUEST_METHOD`, `REQUEST_SCHEME`, `REQUEST_URI`, `SCRIPT_FILENAME`, `SCRIPT_NAME`, `SCRIPT_URI`, `SCRIPT_URL`, `SERVER_ADDR`, `SERVER_ADMIN`, `SERVER_NAME`, `SERVER_PORT`, `SERVER_PROTOCOL`, `SERVER_SIGNATURE`, `SERVER_SOFTWARE`, `SSL_TLS_SNI`, `UNIQUE_ID`, `PHP_SELF`, `REQUEST_TIME_FLOAT`, `REQUEST_TIME`,`TIME_STAMP`) VALUES ('$SE[0]', '$SE[1]', '$SE[2]', '$SE[3]', '$SE[4]', '$SE[5]', '$SE[6]', '$SE[7]', '$SE[8]', '$SE[9]', '$SE[10]', '$SE[11]', '$SE[12]', '$SE[13]', '$SE[14]', '$SE[15]', '$SE[16]', '$SE[17]', '$SE[18]', '$SE[19]', '$SE[20]', '$SE[21]', '$SE[22]', '$SE[23]', '$SE[24]', '$SE[25]', '$SE[26]', '$SE[27]', '$SE[28]', '$SE[29]', '$SE[30]', '$SE[31]', '$SE[32]', '$SE[33]', '$SE[34]', '$SE[35]', '$SE[36]', '$SE[37]', '$SE[38]','$SE[39]','$SE[40]','$SE[41]','$SE[42]','$SE[43]','$SE[44]','$SE[45]','$SE[46]','$SE[47]','$SE[48]','SESSION_VAR')";
			$query_1 = mysqli_query($con,$sql);
						
		
			//MAIL//CONFIRMATION MAIL//OUTPUT 03
			//ATTRIBUTES
			$t=$P[6];
			$s="Explainit Online - קורס 003 - אישור תשלום ובקשה ליצירת קשר";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;direction:rtl;">';
			$message .= '<h4>הי,</h4><h4> אנא צור/י עימנו קשר לגבי התשלום.</h4><h4>המייל הזה מאשר ששילמת 120 ש"ח עבור מנוי לקורס 003 - "מלכים ונביאים – ממלכות מנשה עד חורבן ממלכת יהודה" של ד"ר בועז סתוי, בתוקף עד ל-08.06.19. 
			</h4><h4>מספר אישור '.$P[26].'.</h4><h4> קבלה תישלח תוך 24 שעות.</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($t,$s, $message, $headers);
					
			//REPORT MAIL TO LECTURER
			
			//ATTRIBUTES
			$f="boazstavi@gmail.com";
			$f_1="Explainit Online - קורס 003 - לקוח/ה חדש/ה כנראה עם בעיות בתשלום";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
			
			//echo '<script>setTimeout(function(){document.getElementById("a_1").click();}, 2000);</script>';
				
			if(isset($_SESSION["refresh_count"]) && $_SESSION["refresh_count"] > 2)
			{
				// SLEEPING
				sleep(2);
			}//REFRESH COUNT > 2
			
			if(isset($_SESSION["refresh_count"]) && $_SESSION["refresh_count"] > 4)
			{
				// SLEEPING
				sleep(4);
			}//REFRESH COUNT > 4
			
			if(isset($_SESSION["refresh_count"]) && $_SESSION["refresh_count"] > 6)
			{
				// SLEEPING
				sleep(10);
			}//REFRESH COUNT > 6
		
		//REPORT MAIL TO XO//ATTRIBUTES
			$f="registration@explainit.online";
			$f_1="Explainit Online - קורס 003 - לקוח/ה חדש/ה כנראה עם בעיות תשלום";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$t.'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
			
			//REFRESH COUNT UPDATE
			$_SESSION["refresh_count"]++;
				
		}
		else//REFERER ISN'T DIRECT
		{
			//REPORT MAIL TO XO//ATTRIBUTES//OUTPUT 04
			$f="registration@explainit.online";
			$f_1="003 - SUCCESS - REFERER NOT TRANZILLA - לקוח עם בעיות תשלום";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$P[6].'</h4>';
			$message .= '<h4>IP:</h4>';
			$message .= '<h4>'.$_SERVER["REMOTE_ADDR"].'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
				
			//ERROR PAGE//OUTPUT 05
			header ('location: ../php/error_fi/error_videos_8.php');
		}//REFERER ISN'T DIRECT
	}
	else//METHOD NOT POST
	{
		//REPORT MAIL TO XO//ATTRIBUTES//OUTPUT 04
			$f="registration@explainit.online";
			$f_1="003 - SUCCESS - METHOD NOT POST - לקוח עם בעיות תשלום";
			
			//HEADERS
			$headers = "From: registration@explainit.online\r\n";
			$headers .= "Reply-To:registration@explainit.online\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			//MESSAGE
			$message = '<html lang="iw" dir="rtl"><body>';
			$message .= '<div style="width:100%;margin:auto;text-align:center;">';
			$message .= '<h4>מספר אישור:</h4>';
			$message .= '<h4>'.$P[26].'</h4>';
			$message .= '<h4>מייל:</h4>';
			$message .= '<h4>'.$P[6].'</h4>';
			$message .= '<h4>IP:</h4>';
			$message .= '<h4>'.$_SERVER["REMOTE_ADDR"].'</h4>';
			$message .= "</div>";
			$message .= "</body></html>";
			
			//SENDING
			mail($f,$f_1,$message,$headers);
		
		//ERROR PAGE//OUTPUT 06
		header ('location: ../php/error_fi/error_videos_8.php');
	}
	
	//REFRESH COUNT UPDATE
	$_SESSION["refresh_count"]++;
	
	//SLEEPING
	sleep(2);
	
	//ERROR PAGE//OUTPUT
	header ('location: ../php/error_fi/error_videos_8.php');
}//REFRESH COUNT > 3, silent update	
	/* //DEBUGGING	
		//echo '<pre style="direction:ltr;">';
		//var_dump(get_defined_vars());
		//echo '<br>';
		//var_dump($_POST);
		//echo '<br>';
		//var_dump($_SERVER);
		//echo '<br>';
		//var_dump($_SESSION);
		//echo '<br>'; 
		//echo '</pre>';
	*/
?>
<!DOCTYPE html>
<html lang="iw" dir="rtl">
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
	
	<!-- VIEWPORT -->
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Secular+One" rel="stylesheet">
	
	<!-- CSS --><!-- OUTPUT 02 -->
	<link rel="stylesheet" href="../css/2.css">
	
	<!-- EMOJI CSS -->
	<link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
	
	<!-- JQUERY -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style>
/* TEMPLATE */

	body
		{
			/* Background pattern from Toptal Subtle Patterns */
			background-image:url(../img/background/grey_wash_wall.png);
			color:#f1f1f1;
			font-family:Secular One, Sans Serif;
			box-sizing:border-box;
		}
		
	hr	
		{
			border-top:1px solid #f1f1f1;
		}
		
	input[type="submit"],input[type="email"],input[type="text"],input[type="password"]
		{
			font-family:secular one, sans-serif;
		}
	
	a	{
			text-decoration:none;
			color:#54c539;
		}
		
</style>
</head>
<body>
	<!-- TEXT -->
	<div style="width:80%;text-align:center;margin:auto;">
		<h1 id="a_1">החיוב עבר בהצלחה</h1>
		<h2>אישור נשלח למייל, קבלה תשלח תוך 24 שעות.</h2>
	</div>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<!-- PAYMENT CONFIRMATION TABLE -->
	<div style="width:100%;text-align:center;">
		<table style="width:70%;margin:auto;border:0.5px solid #f1f1f1;border-collapse:collapse;text-align:center;">
			
			<!-- PAYMENT CONFIRMATION NUMBER -->
			<tr>
				<td style="border:0.5px solid #f1f1f1;">מס' אישור תשלום:</td>
				<td style="border:0.5px solid #f1f1f1;"><?=$P[26]; ?></td>
			</tr>
			
			<!-- PAYMENT CONFIRMATION MAIL -->
			<tr>
				<td style="border:0.5px solid #f1f1f1;">מייל:</td>
				<td style="border:0.5px solid #f1f1f1;"><?=$P[6]; ?></td>
			</tr>
			
			<!-- PAYMENT CONFIRMATION AMOUNT -->
			<tr>
				<td style="border:0.5px solid #f1f1f1;">סכום:</td>
				<td style="border:0.5px solid #f1f1f1;"><?=$P[15]; ?> ש"ח</td>
			</tr>
			
			<!-- PAYMENT CONFIRMATION CARD DETAILS -->
			<tr>
				<td style="border:0.5px solid #f1f1f1;">כרטיס אשראי מסתיים בספרות:</td>
				<td style="border:0.5px solid #f1f1f1;"><?=$P[21]; ?></td>
			</tr>
		</table>
	</div>
	
	<!-- HORIZONTAL LINE -->
	<div style="width:50%;margin:auto;">
		<hr>
	</div>
	
	<!-- JOINING PAYMENT WITH MAIL DIV -->	
	<div style="direction:rtl;text-align:center;">
		<!-- TEXT -->
		<h2 id="c" style="margin-bottom:0px;">מה שנשאר זה להכניס את המייל והסיסמה איתם נרשמת לאתר, וללחוץ על התחבר.</h2>
		<i class="em em-writing_hand"></i>
			
		<!-- JOINING PAYMENT WITH MAIL PAGE --><!-- OUTPUT 07 -->
		<form action="../login/example_cleveland_l_videos_3.php" method="post" enctype="multipart/form-data" autocomplete="on">
			<input id="input_1" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="text" placeholder="מייל" name="user_name" required><br>
			<input style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="password" placeholder="סיסמה" name="pass_word" autocomplete="new-password" required><br>
			<input id="input_2" style="margin:4px auto;padding:2px;width:200px;text-align:center;" type="hidden" placeholder="מספר אישור תשלום" name="payment_no" required><br>
			<div style="font-size:14px;"><!-- FORGOT PASSWORD --><!-- OUTPUT 08 --><a href="../login/f_videos.php">שכחתי סיסמה</a></div>
			
			<!-- EMOJI -->
			<div>
				<i id="p" class="em em-airplane"></i>
			</div>
			
			<!-- SUBMIT -->
			<input style="margin:4px auto;padding:2px;font-size:16px;" type="submit" value="התחבר" name="register">
		</form>
	</div><!-- JOINING PAYMENT WITH MAIL DIV -->

<script>
$("#a_1").click(function(){
	$("#input_2").val('<?=$P[26]; ?>');
});
</script>
</body>
</html>

