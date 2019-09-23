<?php

include_once __DIR__ . "/addToCal/calLinksClass.php";

//Prepare the data for the calendar links
$title = 'Meeting with Ben Charbonneau';     // Event title 

$description = "Name: Ben Charbonneau\n"; // Event description

if (!empty($skype)) {
	$description .= "\nSkype Username: fakeskypeusername";
}

if (!empty($email)) {
	$description .=	"\nEmail: fake@fake.com";
}

$dateString = new DateTime("@1569623400");

$duration = 60;

$location = 'Skype Call';

$calDir = 'http://localhost:8888/addToCal';

//Use the CalLinks class to generate the calendar links
$calendarLinks = new CalLinks($title, $description, $location, NULL, $dateString->getTimestamp(), NULL, $duration, $calDir);

$calArray = $calendarLinks->generateCalendars();

//Add a header and styling to the links
$links = '<div><h4>Add to your calendar:</h4>';

foreach ($calArray as $link) {
	//Add styling to the links and add them to the link div

	//Example link from CalLinks: '<a target="_blank" href="https://calendar.google.com">Google Calendar</a>'
	$styledLink = substr($link, 0, 3) . 'style="display: inline-block; cursor: pointer; font-size: 12px; margin-right: 10px;" ' . substr($link, 3);

	$links .= $styledLink;

}

$links .= '</div>';

//At this point you have the HTML for the calendar links. You can now add it to the body of any emails that you're sending out.

?>