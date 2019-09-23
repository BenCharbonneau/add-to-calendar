<?php

class CalLinks{
    protected $title; //Title of the calendar event
    protected $from; //Start date and time
    protected $to; //End date and time
    protected $description; //Description of event
    protected $duration; //Duration of event in minutes
    protected $address; //Location of event
    protected $url; //URL for relevant website page
    protected $calDir; //Directory where the add to calendar functionality is kept (Should have the full host name included. [e.g. http://localhost/addToCal])

    public function __construct($title='',$description='',$address='',$url='',$from,$to,$duration,$calDir){
        //initiate the calendar links object
        $this->title = $title;
  		$this->description = $description;
  		$this->address = $address;
  		$this->url = $url;
        $this->calDir = $calDir;

        //check to make sure that the start time is before the end time or that a duration is set
        if ($from and ($to > $from or !empty($duration))) {
            $this->from = $from;

            //If we're using a duration instead of an end time, calculate the end time
            if (!isset($to)) {
            	$to = $from + $duration * 60;
            }
        	$this->to = $to;	 
        }    	
    }

    public function google() {
        //Create google calendar link
    	$href = 'https://www.google.com/calendar/render' .
        '?action=TEMPLATE' .
        '&text=' . urlencode($this->title) .
        //Date gets converted to YYYYMMDD'T'HHMMSS'Z' format (eg. 20190201T135130Z for 2/01/2019 at 13:51:30 UTC) this is the ISO format.
        '&dates=' . date('Ymd\THis\Z',$this->from) . 
        '/' . date('Ymd\THis\Z',$this->to) .
        '&details=' . urlencode($this->description) .
        '&location=' . urlencode($this->address) .
        '&sprop=&sprop=name:';

    	return '<a target="_blank" href="' . $href . '">Google</a>';
    }

    public function outlook() {
        //Create outlook web app calendar link
        $href = 'https://outlook.live.com/owa' .
        '?path=/calendar/action/compose&rru=addevent' .
        '&subject=' . urlencode($this->title) . 
        //Date gets converted to YYYYMMDD'T'HHMMSS'Z' format (ISO format)
        '&startdt=' . date('Ymd\THis\Z',$this->from) . 
        '&enddt=' . date('Ymd\THis\Z',$this->to) . 
        '&uid=' . urlencode(date('Ymd')."T".date('His')."-".rand()."-rocketblocks.me") . 
        '&body=' . urlencode($this->description) . 
        '&location=' . urlencode($this->address);

        return '<a target="_blank" href="' . $href . '">Outlook.com</a>';
    }

    public function yahoo() {
        //Create yahoo calendar link

        //Start time gets converted to ISO format
    	$start = date('Ymd\THis\Z',$this->from);

        //Yahoo doesn't use end times so we need to create a formatted duration for them in the format HHMM
    	
        //Get the duration in minutes
        $yahooDuration = floor(($this->to - $this->from)/60);

        //Calculate hours and make sure that they have a leading zero
    	if ($yahooDuration < 600) {
      		$yahooHours = '0' . strval(floor($yahooDuration/60));
    	}
    	else {
      		$yahooHours = strval(floor($yahooDuration/60));
    	}

        //Calculate minutes and make sure that they have a leading zero
    	if ($yahooDuration % 60 < 10) {
      		$yahooMinutes = '0' . strval($yahooDuration % 60);
    	}
    	else {
      		$yahooMinutes = strval($yahooDuration % 60);
    	}

        //Concatenate the hours and minutes to get a formatted duration string
    	$yahooEventDuration = $yahooHours . $yahooMinutes;

        //Create url string
    	$href = 'http://calendar.yahoo.com/?v=60&view=d&type=20' .
        	'&title=' . $this->title .
        	'&st=' . $start .
        	'&dur=' . $yahooEventDuration .
        	'&desc=' . urlencode($this->description) .
        	'&in_loc=' . urlencode($this->address);

    	return '<a target="_blank" href="' . $href . '">Yahoo</a>';
    }

    public function ics($calendarName) {
        //Create a link to the icsGenerator which will create an ics file on the fly when a user browses to it
        //ICS files can be used by many calendar apps so this method accepts a calendarName parameter that can be used to describe the calendar app that this link is intended for

        //Times get converted to ISO format
    	$startTime = date('Ymd\THis\Z',$this->from);
    	$endTime = date('Ymd\THis\Z',$this->to);

        $url = $this->calDir . "/icsGenerator.php?".
        "start=".$startTime."&".
        "end=".$endTime."&".
        "title=".urlencode($this->title);

        if ($this->url) {
         $url .= "&url=".urlencode($this->url);
        }
        if ($this->description) {
            $url .= '&description='.addcslashes($this->description, "\n");
        }
        if ($this->address) {
            $url .= '&address='.str_replace(',', '', $this->address);
        }

    	return '<a href="' . $url . '" download>' . $calendarName . '</a>';
    }

    public function ical() {
        //Generate a generic link that will generate an ICS file for other calendars
    	return $this->ics('ICS file (for Apple Calendar, Outlook Desktop and others)');
    }

    public function generateCalendars() {
        //Generate calendar links and return them in an array

        $tz = date_default_timezone_get();

        date_default_timezone_set('UTC');

	  	$calendars = array();
	  	$calendars['google'] = $this->google();
	  	$calendars['outlook'] = $this->outlook();
        $calendars['yahoo'] = $this->yahoo();
	    $calendars['ical'] = $this->ical();

        date_default_timezone_set($tz);

	    return $calendars;
	}
}
?>