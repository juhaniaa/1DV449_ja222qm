<?php

$data = curl_get_request("http://coursepress.lnu.se/kurser");
var_dump($data);

function curl_get_request($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$data = curl_exec($ch);
	
	curl_close($ch);
	
	return $data;
	
}
