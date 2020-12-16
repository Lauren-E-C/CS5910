<?php

include_once '../models/Calendar.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $calendar_id = $_GET['calendarID'];
} else {
    $calendar_id = $_POST['calendarID'];
}

$calendar = new Calendar();  // create new instance of a calendar model

$calendar_record = $calendar->get([
    'calendarID' => $calendar_id   // fetch the course record based on the calendar id
]);

$calendar_listed = $calendar->getValue('listed');

$listed = 'Y';
if ($calendar_listed == 'Y') {
    $listed = 'N';
}

try {
    $calendar->update([
        'listed' => $listed
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
}

header("Location: admin_calendar_edit.php?calendarID=$calendar_id");
exit;