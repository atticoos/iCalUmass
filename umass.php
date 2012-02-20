#!/usr/bin/php
<?php
include_once('iCal.php');
date_default_timezone_set('America/New_York');


$calendar_endpoint = "calendar_template.html";


$iCal = new iCal();
$ics = $iCal->getICS($calendar_endpoint);
echo $ics;
?>
