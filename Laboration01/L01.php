<?php

require_once("/html5lib-php-master/library/HTML5/Parser.php");

echo "	<!DOCTYPE html>
		<html lang='sv'>
			<head>
				<title>Labb 1 - Webbteknik 2</title>
				<meta charset='utf-8' />
			</head>
			<body>
				<ul>";	

$data = curl_get_request("http://coursepress.lnu.se/kurser/");

$dom = new DOMDocument();

if($dom->loadHTML($data)){
	$xpath = new DOMXPath($dom);

	$courses = $xpath->query("//ul[@id = 'blogs-list']//div[@class = 'item-title']/a[contains(@href, 'lnu.se/kurs')]");
	
	// varje "blog"-element i listan
	foreach ($courses as $course) {
		
		$cName = $course->nodeValue;
		$cUrl = $course->getAttribute("href");
		
		// gå in på varje länk för att hitta ytterligare info
		$cData = curl_get_request($cUrl);
		
		$libDom = HTML5_Parser::parse($cData);
		var_dump($libDom);
		echo "thats doc</br>";
		
		$libXpath = new DOMXPath($libDom);
			
		$libNodeList = $libXpath->query("//body/div[@id = 'page']//li");
		
		var_dump($libNodeList);
		
		
		
		
		//var_dump($libDom->textContent);
		//$nodelist = HTML5_Parser::parseFragment('<li></li>', 'header');
		//var_dump($nodelist);
		//echo "thats Nodelist</br>";
		
		//$node = $nodelist->item(0)->nodeValue;
		//var_dump($node);
		
		//foreach ($nodelist as $testNode) {
			//var_dump($testNode->nodeValue);
		//}
		
		/*
		$cDom = new DOMDocument();
		//libxml_use_internal_errors(true);
		
		$cElement = $cDom->getElementById("header-wrapper");
		var_dump($cElement);
		echo $cElement;
		
		if($cDom->loadHTML($cData)){
			$cXpath = new DOMXPath($cDom);
			
			echo $cXpath;
			
			//$cCode = $cXpath->query("/div[@id = 'page']/div[@id = 'header-wrapper']/ul//li");
			//$cCode = $cXpath->query("//body/div[@id = 'page']/div[@id = 'header-wrapper']//li");
			$cCode = $cXpath->query("//body/div[@id = 'page']//li");
			var_dump($cCode);
			
			foreach ($cCode as $item) {
				$test = $item->nodeValue;
				var_dump($test);
				echo "hej";
			}
			
			//$cCode = $cCode->item(0)->nodeValue;
			//var_dump($cCode);
		}
		//libxml_use_internal_errors(false);
		 * 
		 * 
		 */
		
		$html = "<li><ul>
		<li>Name: " . $cName . "</li>
		<li>URL: " . $cUrl . "</li>
		<li>Code: </li>
		<li>Syllabus: </li>
		<li>Info: </li>
		<li>Latest post: </li>		
		</ul></li></br>";
		echo $html;
	}
}



else {
	die("HTML läsningen misslyckades");
}
echo "</ul>
	</body>
	</html>";

function curl_get_request($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$data = curl_exec($ch);
	
	curl_close($ch);
	
	return $data;
	
}
