<?php

set_time_limit (60);
libxml_use_internal_errors(true);

header('Content-Type: text/html; charset=ISO-8859-1');

echo "	<!DOCTYPE html>
		<html lang='sv'>
			<head>
				<title>Labb 1 - Webbteknik 2</title>
				<meta http-equiv='Content-type' content='text/html; charset=ISO-8859-1' />
			</head>
			<body>
				<ul>";	

getAllPages("/kurser/");

echo "</ul>
	</body>
	</html>";
	
function getURL($URL) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL); 
    //curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    $curlData = curl_exec($ch);
	curl_close($ch);
	return $curlData;
}

function getAllPages($extUrl){
	
	$base = "http://coursepress.lnu.se";
	$url = $base . $extUrl;
	
	$dom = new DOMDocument();
	
	if($dom->loadHTML(getURL($url))){
	    $xpath = new DOMXPath($dom);
	    $courses = $xpath->query("//ul[@id = 'blogs-list']//div[@class = 'item-title']/a[contains(@href, 'lnu.se/kurs')]");
		
		echo getPageCoursesHtml($courses);
		
		$nextPage = $xpath->query("//div[@id = 'blog-dir-pag-top']//a[contains(@class, 'next')]");
		
		if($nextPage->length != 0){
			
			$href = "";
			
			foreach ($nextPage as $page) {
				$href = $page->getAttribute("href");
			}
			
			getAllPages($href);
			
		} else {
			// done
		}  
		
	}
}

function getPageCoursesHtml($courses){
		
	$noInfo = "no information";
	
	// varje "blog"-element i listan
    foreach ($courses as $course) {    	
		
        $cName = $course->nodeValue;
        $cUrl = $course->getAttribute("href");

        $dom = new DOMDocument();
        if($dom->loadHTML(getURL($cUrl))){
            $xpath = new DOMXPath($dom);

			$course_code = $xpath->query("//div[@id = 'header-wrapper']//li[3]");
			$cCode = $noInfo;
			if($course_code->length != 0){
				$cCode = $course_code->item(0)->nodeValue;	
			}
			
			$course_syllabus = $xpath->query("//ul[@class = 'sub-menu']//li//a[contains(@href, 'prod')]");		
			$cSyllabus = $noInfo;
			if($course_syllabus->length != 0){
				$cSyllabus = $course_syllabus->item(0)->getAttribute("href");	
			}

			$course_info = $xpath->query("//div[@class = 'entry-content']");		
			$cInfo = $noInfo;		
			if($course_info->length != 0){
				$cInfo = $course_info->item(0)->nodeValue;	
			}
			
			$course_postHeader = $xpath->query("//div[@id = 'content']/section/article[1]/header[@class = 'entry-header']/h1//a[1]");		
			$cPostHeader = $noInfo;
			if($course_postHeader->length != 0){
				$cPostHeader = $course_postHeader->item(0)->nodeValue;	
			}
			
			$course_postInfo = $xpath->query("//div[@id = 'content']/section/article[1]/header[@class = 'entry-header']/p");		
			$cPostInfo = $noInfo;
			if($course_postInfo->length != 0){
				$cPostInfo = $course_postInfo->item(0)->nodeValue;	
			}
			
			$ret = "<li><ul>
			<li>Name: " . $cName . "</li>
			<li>URL: " . $cUrl . "</li>
			<li>Code: " . $cCode . "</li>
			<li>Syllabus: " . $cSyllabus . "</li>
			<li>Info: " . $cInfo . "</li>
			<li>Latest post: " . $cPostHeader . " " . $cPostInfo . "</li>		
			</ul></li></br>";
			
			echo $ret;
        }
    }
}