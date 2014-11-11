<?php

libxml_use_internal_errors(true);
//$BASE_URL = 'http://localhost:8888/secure/';
$BASE_URL = 'http://coursepress.lnu.se/kurser/';


function getURL($URL) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL); 
    //curl_setopt($ch, CURLOPT_HEADER, true);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
    return curl_exec($ch);
}


$dom = new DOMDocument();

//$data = getURL("http://coursepress.lnu.se/kurser/");

if($dom->loadHTML(getURL($BASE_URL))){
    $xpath = new DOMXPath($dom);
    $courses = $xpath->query("//ul[@id = 'blogs-list']//div[@class = 'item-title']/a[contains(@href, 'lnu.se/kurs')]");

    // varje "blog"-element i listan
    foreach ($courses as $course) {

        $cName = $course->nodeValue;
        $cUrl = $course->getAttribute("href");

        $dom = new DOMDocument();
        if($dom->loadHTML(getURL($cUrl))){
            $xpath = new DOMXPath($dom);

            // Uttrycket under plockar alla li-element som ligger i en div med attributet id satt till "header-wrapper"
            //$course_data = $xpath->query("//div[@id='header-wrapper']//li");

            // plockar alla li-element som ligger i header-element (för att testa HTML5)
            //$course_data = $xpath->query("//header//li");
			$course_data = $xpath->query("//div[@id = 'header-wrapper']//li");
			//echo $course_data->nodeValue;
			//$course_data = $xpath->query("//body/div[@id = 'page']/div[@id = 'header-wrapper']//li");

            foreach($course_data as $d) {

                echo($d->nodeValue);
                echo "<br />";
            }
            die();
        }
    }
}