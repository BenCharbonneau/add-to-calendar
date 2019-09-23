<?php

include_once __DIR__ . "/calLinksClass.php";

if (isset($_POST['fromAjax'])) {

	//Use CalLinks class to generate an Add to Calendar link for each of the popular calendars
	$calendarLinks = new CalLinks($_POST['title'], $_POST['description'], $_POST['address'], $_POST['url'], $_POST['from'], $_POST['to'], $_POST['duration'], $_POST['calDir']);

	echo json_encode($calendarLinks->generateCalendars());
}

?>