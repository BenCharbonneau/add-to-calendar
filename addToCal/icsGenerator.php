<?php

	//Get the properties of the calendar event from the query parameters
	$start = $_GET['start'];
	$end = $_GET['end'];
	$title = $_GET['title'];
	$address = $_GET['address'];
	$url = $_GET['url'];
	$description = $_GET['description'];

	//Generate and send the ICS file
	header("Content-Type: text/Calendar");
	header("Content-Disposition: inline; filename=calendar.ics");
	echo "BEGIN:VCALENDAR\n";
	echo "VERSION:2.0\n";
	echo "METHOD:REQUEST\n"; // required by Outlook
	echo "BEGIN:VEVENT\n";
	echo "UID:".date('Ymd').'T'.date('His')."-".rand()."-rocketblocks.me\n"; // required by Outlook
	echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n"; // required by Outlook
	echo "DTSTART:".$start."\n"; //Event start
	echo "DTEND:".$end."\n"; //Event end
	echo "SUMMARY:".$title."\n"; //Event title
	echo "DESCRIPTION: ".$description."\n"; //Event description
	echo "LOCATION:".$address."\n"; //Event location
	echo "URL:".$url."\n"; //URL to relevant website page
	echo "END:VEVENT\n";
	echo "END:VCALENDAR\n";
?>