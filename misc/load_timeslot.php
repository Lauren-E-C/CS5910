<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

$fin_csv = fopen($_SERVER['DOCUMENT_ROOT'] . "/misc/csv2/great_courses.txt", "r");

if (!$fin_csv) die("field to open file");

$timeslot = new TimeSlot();

$timeslotData = $timeslot->getMax("ID");
$max = $timeslotData["max"];

if (!$max) {
    $timeslot_id = 1;
} else {
    $timeslot_id = $max + 1;
}

//    I = 8 J = 9

while ($columns = fgetcsv($fin_csv)) {



    $time_string = $columns[8];
//    $days_of_week = str_split($columns[9]);
    $days_of_week = $columns[9];

    if ($time_string == 'TBA') continue;
    if (preg_match('/TBA/', $time_string)) continue;

    list($start_time, $end_time) = preg_split("/ - /", $time_string);

    echo "time_string: $time_string\n";

    $start_time = $timeslot->parseTime($start_time);
    $end_time = $timeslot->parseTime($end_time);

    $timeslotData = $timeslot->get([
        'DaysOfWeek' => $days_of_week,
        'StartTime' => $start_time,
        'EndTime' => $end_time
    ]);

    if ($timeslotData == false) {
        print_r([
            'ID' => $timeslot_id++,
            'DaysOfWeek' => $days_of_week,
            'StartTime' => $start_time,
            'EndTime' => $end_time
        ]);
        $timeslot->create([
            'ID' => $timeslot_id++,
            'DaysOfWeek' => $days_of_week,
            'StartTime' => $start_time,
            'EndTime' => $end_time
        ]);
    }
}