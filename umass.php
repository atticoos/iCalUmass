#!/usr/bin/php
<?php
include_once('includes/simple_html_dom.php');
date_default_timezone_set('America/New_York');


$calendar_endpoint = "calendar_template.html";


$iCal = new UmassICal();
$ics = $iCal->getICS($calendar_endpoint);
echo $ics;





class UmassICal
{	

	function getICS($calendar_endpoint){
		$cal_raw = file_get_html($calendar_endpoint);
		$header = $this->getHeader();
		$body = $this->translateCalendar($cal_raw);
		$footer = $this->getFooter();
		return $header  . $body . $footer;
	}
	
	function translateCalendar($cal){
		$body = "";
		foreach ($cal->find('tr') as $tr) {
			$i = 0;
			$title = null;
			$date = null;
			foreach($tr->find('td') as $i=>$td){
				if ($i==0){
					$title = $td->plaintext;
				}
			}
			$body .= $this->buildEvent($title, date(time()));
		}
		return $body;
	}
	
	
	function getHeader(){
		$header = "BEGIN:VCALENDAR\n";
		$header .= "VERSION:2.0\n";
		$header .= "PROGID:-//atticus/test/NONSGML v1.0//EN\n";
		return $header;
	}
	
	function getFooter(){
		return "END:VCALENDAR\n";
	}
	
	function buildEvent($title, $date){
		$body = "BEGIN:VEVENT\n";
		$body .= "UID:uid1@example.com\n";
		$body .= "DTSAMP:19970714T170000Z\n";
		$body .= "ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com\n";
		$body .= "DTSTART:19970714T170000Z\n";
		$body .= "DTEND:19970715T035959Z\n";
		$body .= "SUMMARY:$title\n";
		$body .= "END:VEVENT\n";
		return $body;
	}
}

/*

FORMAT

BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN

BEGIN:VEVENT
UID:uid1@example.com
DTSTAMP:19970714T170000Z
ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com
DTSTART:19970714T170000Z
DTEND:19970715T035959Z
SUMMARY:Bastille Day Party
END:VEVENT

END:VCALENDAR
*/


?>
