function appendCalendar(tagForAppend,data,calDir) {

  //Check to see if we have all of the parameters that we need
  if (!validParams(data)) {
    return;
  }

  //If we do, generate the Add to Calendar button and append it to the given css tag
  generateCalendars(tagForAppend,data,calDir);
};

var generateCalendars = function(tagForAppend,event,calDir) {
  //Use the url of the current page as a reference link in the calendar invite
  event.url = document.URL;
  event.from = event.start;
  event.to = event.end;
  event.fromAjax = true;
  event.calDir = calDir;

  //Use ajax to get the generated calendar links
  var calendars = $.ajax ({
      type: "POST",
      data: event,
      url: calDir + "/addToCal.php",
      dataType: "json"
  });

  //Create the button HTML and append the links to the HTML element with the correct tag
  calendars.done(function(){
    generateMarkup(tagForAppend,calendars.responseJSON);
  });
  
};

// Make sure we have the necessary event data, such as start time and event duration
var validParams = function(data) {
  return data !== undefined && data.start !== undefined &&
    (data.end !== undefined || data.duration !== undefined);
};

var generateMarkup = function(tagForAppend,calendars) {
  //Create the dropdown button HTML using Bootstrap
  if (!calendars) return;
  var result = document.createElement('ul');
  result.className = "dropdown-menu";
  result.setAttribute('aria-labelledby','dropdownMenuButton');

  //Add the calendar links to the dropdown
  Object.keys(calendars).forEach(function(services) {
    result.innerHTML += '<li class="dropdown-item">' + calendars[services] +'</li>';
  });

  //Append the button to the HTML element with the specified tag
  $(tagForAppend).append(result);
};

    
