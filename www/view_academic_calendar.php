<?php
$roles = null;
$page_title = "Academic Calendar";
include_once 'header.php';


$calendar = new Calendar();  // create model to get access to the "Calendar" table

// gather all events as an associative array
// store calendar id as key
// store calendar name as value
$calendar_values = array();

$calendar_record = $calendar->get();  // get first record
while ($calendar_record) {   // loop until no more data

    // get the data from the columns
    $calendar_id = $calendar->getValue('Calendar ID');
    $event = $calendar->getValue('Event');

    // store in associative array
    $calendar_values[$calendar_id] = $event;


    // get the next record from table if any
    $calendar_record = $calendar->next();
}

// create a select list field with the key/values from the calendar table
$calendar_field = new KeyValueField('Calendar', $calendar_values);

// create a form using the HTTP "get" method
$f = new Form("GET");

// display the form
$form_data = $f->showForm([
    'CalendarID' => $calendar_field // show $calendar_field in one bootstrap row
]);


// if the user submitted the form, then do something with the submitted data
if ($form_data) {
    $calendar_id = $form_data['CalendarID']; // get the user submitted calendar id

    // create a grid for the Event model that shows the event name
    $g = new Grid(new Course(), [
        'id' =>  'Calendar ID',
        'date' =>  'Date',
        'event' =>  'event',

    ]);

} else {
    echo "Calendar not selected";
}

?>