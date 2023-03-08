<?php
require_once('../config.php');
require_once($CFG->dirroot . '/course/lib.php');

	
/* 	$url = 'https://www.example.com';
 
$curl = curl_init();
 
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
 
$data = curl_exec($curl);
 print_object($data);
curl_close($curl);

 */ $url = 'https://stage.svhs.co/remove-cart-item-ajax';
 
$curl = curl_init();

 
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_COOKIESESSION, true);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
 
$data = curl_exec($curl);
 print_object($data);
curl_close($curl);
	


?>