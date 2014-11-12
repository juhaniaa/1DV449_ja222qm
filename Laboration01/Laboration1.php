<?php
header('Content-Type: text/html; charset=utf-8');
libxml_use_internal_errors(true);

$myScraper = new Scraper;

$myScraper->getAllPages("/kurser/");

//$myScraper->numberOfPages . " number of courses scraped";

$myJson = array('name'=>'Webbteknik', 'code'=>12354, 'url'=>'http://prod.kursinfo.lnu.se/utbildning/GenerateDocument.ashx?templatetype=coursesyllabus&amp;code=1DV433&amp;documenttype=pdf&amp;lang=sv');

file_put_contents('items.json', json_encode($myScraper->coursesArray, JSON_UNESCAPED_UNICODE));

echo "DONE";

class Scraper{
	public $numberOfPages;
	public $coursesArray;
	
	public function __construct(){
		$this->numberOfPages = 0;
		$this->coursesArray = array();
	}
	
	public function getURL($URL) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $URL); 
	    //curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	    $curlData = curl_exec($ch);
		curl_close($ch);
		return $curlData;
	}
	
	public function getAllPages($extUrl){
		
		$amount = 0;
		
		$base = "http://coursepress.lnu.se";
		$url = $base . $extUrl;
		
		$dom = new DOMDocument();
		
		if($dom->loadHTML($this->getURL($url))){
		    $xpath = new DOMXPath($dom);
		    $courses = $xpath->query("//ul[@id = 'blogs-list']//div[@class = 'item-title']/a[contains(@href, 'lnu.se/kurs')]");
			
			$amount = $this->getPageCoursesHtml($courses);
			$this->numberOfPages += $amount;
			
			$nextPage = $xpath->query("//div[@id = 'blog-dir-pag-top']//a[contains(@class, 'next')]");
			
			if($nextPage->length != 0){
				
				$href = "";
				
				foreach ($nextPage as $page) {
					$href = $page->getAttribute("href");
				}
				
				$this->getAllPages($href);
				
			} else {
				// done
			}  		
		}	
	}
	
	public function getPageCoursesHtml($courses){
		$amount = 0;
		$noInfo = "no information";
		
		// varje "blog"-element i listan
	    foreach ($courses as $course) {    	
			$amount = $amount + 1;
	        $cName = $course->nodeValue;
	        $cUrl = $course->getAttribute("href");
	
	        $dom = new DOMDocument();
	        if($dom->loadHTML($this->getURL($cUrl))){
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
				
				$arrCourse = array('Name'=>$cName, 'Url'=>$cUrl, 'Code'=>$cCode, 'Syllabus'=>$cSyllabus, 'Info'=>$cInfo, 'PostHeader'=>$cPostHeader, 'PostInfo'=>$cPostInfo);
				
				$this->coursesArray[] = $arrCourse;
	        }
	    }
		return $amount;
	}
}




