<?php 
// create curl resource 
$ch = curl_init(); 

// set url 
curl_setopt($ch, CURLOPT_URL, "https://www.101soundboards.com" . $_SERVER['REQUEST_URI']); 

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_HEADER, 1);

// $output contains the output string 
if(FALSE === $response = curl_exec($ch)){
	die("fart");
}

$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headerSection = substr($response, 0, $header_size);

$body = substr($response, $header_size);

// close curl resource to free up system resources 
curl_close($ch);      

//var_dump($headerSection);

$headersLines = explode("\r\n",$headerSection);
$headersArray = array();
foreach($headersLines as $header){
	if(FALSE === $colonPos = strpos($header, ":")) {
		continue;
	}
	$headersArray[strtoupper(substr($header,0,$colonPos))] = trim(substr($header,$colonPos+1));
}
//var_dump($headersArray);
//exit;
if(isset($headersArray['CONTENT-TYPE'])){
	header('Content-Type: '.$headersArray['CONTENT-TYPE']);
}
//|| (isset($headersArray['CONTENT-TYPE']) && substr($headersArray['CONTENT-TYPE'],0,9) === 'text/html')
if($_SERVER['REQUEST_URI'] === '/' ){

	$body = str_ireplace('<img src="/img/101soundsboards-logo.svg" width="303" height="50" alt="101soundboards.com" />','101fartboards.com', $body);
	$body = str_ireplace('101soundboards','101fartboards', $body);
	$body = str_ireplace(' sound',' fart', $body);
}

echo $body;