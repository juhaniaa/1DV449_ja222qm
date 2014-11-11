<?php

require_once("simple_html_dom.php");
require_once("/html5lib-php-master/library/HTML5/Parser.php");

echo "	<!DOCTYPE html>
		<html lang='sv'>
			<head>
				<title>Labb 1 - Webbteknik 2</title>
				<meta charset='utf-8' />
			</head>
			<body>
				<ul>";	

getAllPages("/kurser/");


echo "</ul>
	</body>
	</html>";
	
function getAllPages($url){
	$base = "http://coursepress.lnu.se";
	$url = $base . $url;
	
	$retHtml = "";
	
	$start = file_get_html($url);
	
	$courses = $start->find("div.item-title a[href*=kurs]");
	
	echo getPageCoursesHtml($courses);
	
	$nextPage = $start->find("div[id=pag-top] a.next", 0);
	
	if($nextPage){
		echo "it exists";
		getAllPages($nextPage->href);
	} else {
		echo "dosnt exist";
	}
	
	return $retHtml;
	
	/*
	$retHtml = "";
	
	// 1 Request på /kurser/
	$data = curl_get_request("http://coursepress.lnu.se/kurser/");
	
	$dom = new DOMDocument();
	if($dom->loadHTML($data)){
		
		$xpath = new DOMXPath($dom);
		
		// hämta ut alla kurs-länkar från hämtade html datat
		$courses = $xpath->query("//ul[@id = 'blogs-list']//div[@class = 'item-title']/a[contains(@href, 'lnu.se/kurs')]");
		
		//$retHtml .= getPageCoursesHtml($courses);
		
		// kolla om $dom innehåller en "next-page"-knapp		
		$nextPageNode = $xpath->query("//div[@id = 'blogs-dir-list']//div[@id = 'blog-dir-count-top']//a[@class = 'next']");
		var_dump($nextPageNode);
		
		// om ja...kör igen från steg 1 med nytt data
		
	}

	else {
		die("HTML läsningen misslyckades");
	}
	
	return $retHtml;*/
}
	
function getPageCoursesHtml($courses){
	
	$ret = "";
	$html = "";
		
	// varje "blog"-element i listan
	foreach ($courses as $course) {
		
		$noInfo = "no information";
		
		/* Name */
		$cName = $noInfo;
		$cName = $course->plaintext;
		
		/* URL */
		$cUrl = $noInfo;
		$cUrl = $course->href;
		
		$html = file_get_html($cUrl);
		
		/* Code */
		$cCode = $noInfo;
		$cNode = $html->find('div[id=header-wrapper] li', 2);
		if($cNode){
			$cCode = $cNode->plaintext;
		}
		
		/* Syllabus */
		$cSyllabus = $noInfo;
		$sNode = $html->find("ul.sub-menu li a[href*=prod]", 0);	
		if($sNode){
			$cSyllabus = $sNode->href;
		}			
		
		/* Information */
		$cInfo = $noInfo;
		$iNode = $html->find("div.entry-content", 0);	
		if($iNode){	
			$cInfo = $iNode->plaintext;
		}
		
		/* Latest post header */
		$cPostHeader = $noInfo;
		$postHeaderNode = $html->find("#content header.entry-header h1 a", 0);
		if($postHeaderNode){
			$cPostHeader = $postHeaderNode->plaintext;	
		}
		
		/* Latest post writer and date/time */
		$cWriter = $noInfo;
		$postWriterNode = $html->find("#content header.entry-header p.entry-byline", 0);
		if($postWriterNode){
			$cWriter = $postWriterNode->plaintext;
		}

		$ret .= "<li><ul>
		<li>Name: " . $cName . "</li>
		<li>URL: " . $cUrl . "</li>
		<li>Code: " . $cCode . "</li>
		<li>Syllabus: " . $cSyllabus . "</li>
		<li>Info: " . $cInfo . "</li>
		<li>Latest post: " . $cPostHeader . " " . $cWriter . "</li>		
		</ul></li></br>";
	}

	$html->clear();
	unset($html);
	
	return $ret;
}

function curl_get_request($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	$data = curl_exec($ch);
	curl_close($ch);
	
	return $data;
}
