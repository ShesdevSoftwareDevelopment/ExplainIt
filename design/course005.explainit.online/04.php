<?php
	$tranzila_api_host = "www.explainit.online";
	//$tranzila_api_path = "/cgi-bin/tranzila71dt.cgi";
	$tranzila_api_path = "";
	
	// Prepare transaction parameters
	$query_parameters["supplier"] = "";// "TERMINAL_NAME" should be replaced by actual terminal name
	$query_parameters["sum"] = ""; //Transaction sum
	$query_parameters["currency"] = ""; //Type of currency 1 NIS, 2 USD, 978 EUR, 826 GBP, 392 JPY
	$query_parameters["TranzilaPW"] = ""; // Token password if required
	$query_parameters["op"] = ""; //Required for handshake
	
	// Prepare query string
	$query_string = "";
	foreach ($query_parameters as $name => $value) 
	{
		$query_string .= $name . "=" . $value . "&";
	}
	
	$query_string = substr($query_string, 0, -1); // Remove trailing "&"
	
	// Initiate CURL
	$cr = curl_init();
	
	curl_setopt($cr, CURLOPT_URL, "https://$tranzila_api_host$tranzila_api_path");
	curl_setopt($cr, CURLOPT_POST, 1);
	curl_setopt($cr, CURLOPT_FAILONERROR, true);
	curl_setopt($cr, CURLOPT_POSTFIELDS, $query_string);
	curl_setopt($cr, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($cr, CURLOPT_SSL_VERIFYPEER, 0);
	
	// Execute request
	$result = curl_exec($cr);
	$error = curl_error($cr);
	
	if (!empty($error)) 
	{
		die ($error);
	}
	
	curl_close($cr);
	
	// Preparing associative array with response data
	$response_array = explode("&", $result);
	$response_assoc = array();
	
	if (count($response_array) > 1) 
	{
		foreach ($response_array as $value) 
		{
			$tmp = explode("=", $value);
			
			if (count($tmp) > 1) 	
			{
				$response_assoc[$tmp[0]] = $tmp[1];
			}
		}
	}
	
	//echo $result;
	echo $_SERVER['REMOTE_ADDR'];

	die ($result . "\n");

?>