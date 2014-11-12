<?php
header('Content-Type: text/html; charset=utf-8');
libxml_use_internal_errors(true);

$doScrape = false;

// first check if file exists and if 5 minutes have passed since last scrape
$str_data = file_get_contents('items.json');
if($str_data !== false){
	$data = json_decode($str_data,true);
	$lastTime = $data["time"];
	
	$timePassed = (time()-$lastTime) > 300;
	if($timePassed){
		$doScrape = true;
	}
} else {
	$doScrape = true;
}

if($doScrape){
	$myScraper = new Scraper;
	$myScraper->getAllPages("/kurser/");
	$coursesJson = $myScraper->coursesArray;
	$readyJson = array(
		'courses'=>$coursesJson,
		'amount'=>$myScraper->numberOfPages,
		'time'=>time()
	);
	
	file_put_contents('items.json', json_encode($readyJson, JSON_FORCE_OBJECT));
	
	echo "DONE";
} else {
	echo "Timelimit has not passed";
}

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
		curl_setopt($ch,CURLOPT_USERAGENT,'ja222qm Scraper');
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