# Add to Calendar Link Generator

A JS and PHP library that lets you add "add to calendar" links to your website or emails. This code was written for [RocketBlocks](https://rocketblocks.me) who generously let me open source it.

## Dependencies
[Bootstrap 4](https://getbootstrap.com/docs/4.2)
[jQuery](https://jquery.com)
[PHP](https://www.php.net)

## How to use it
Download the repo and add the addToCal directory to your site.

There are two main entry points to the code:

appendCalendar - 
	
	Description: 
	
	Parameters:

	- tagForAppend: The selector for the element that you want to append the calendar buttons to.

	- data: An object with the event details. The event parameters are:
		
		- start: Event start date as a UNIX timestamp
		- end: Event end date as a UNIX timestamp
		- title: Event title 
	    - duration: Event duration in minutes
	    - address: Event location (e.g. 100 Main St. or Skype Call)
	    - description: Event description, the body of the calendar invite.
	    - url: URL for relevant website. (e.g. https://google.com)

	- calDir: The location of the directory where the add to calendar code is kept. (e.g. http://localhost:8888/addToCal or /addToCal)

	Example Code:

		appendCalendar(
			'#add-to-cal',
			{
	          title: 'Meeting with Ben',     // Event title
	          start: 1569623400,   // Event start date (UNIX timestamp)
	          duration: 60,                            // Event duration (IN MINUTES)
	          address: 'Skype Call',
	          description: 'Ben Charbonneau\n\nEmail: fake@fake.com\nSkype Username: fakeskypeusername'
	        },
	        'http://localhost:8888/addToCal'
        );

        <div class="dropdown btn-group" id="add-to-cal">
			<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Add to Calendar
			</button>
		</div>


generateCalendars in the CalLinks class - 

	Description: Generates the anchor tags for the different calendar types and puts them in an array. The types are google, yahoo, outlook, and ical.
	
	CalLinks Class Parameters:

	- title: Event title
	- description: Event description, the body of the calendar invite.
	- address: Event location (e.g. 100 Main St. or Skype Call)
	- url: URL for relevant website. (e.g. https://google.com)
	- from: Event start date as a UNIX timestamp
	- to: Event end date as a UNIX timestamp
	- duration: Event duration in minutes
	- calDir: The location of the directory where the add to calendar code is kept. This needs to have the full host name of your website so that it works from email. (e.g. http://localhost:8888/addToCal)

	Example Code:

	if (isset($_POST['fromAjax'])) {

		$calendarLinks = new CalLinks($_POST['title'], $_POST['description'], $_POST['address'], $_POST['url'], $_POST['from'], $_POST['to'], $_POST['duration'], $_POST['calDir']);

		echo json_encode($calendarLinks->generateCalendars());
	}

# Example calendar button

You can take a look at example.html to see the add calendar JS in action.

# Example code for creating email links (PHP)

You can take a look at exampleEmail.php to see example code for using the calendar links in an email.

## License

[MIT](http://opensource.org/licenses/MIT)

Thanks to Carl Sednaoui. The initial code came from his [add to calendar button code](https://github.com/carlsednaoui/add-to-calendar-buttons).