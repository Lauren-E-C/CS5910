<?php
include_once 'admin_manage_researcher_header.php';


$g = new Grid(new NightSection(),[
    'CourseRegistrationNumber' => 'Course Registration<br>Number',
    ':r_01' => ['Course<br>Name', 'Course', 'coursename'],
    ':r_02' => ['Days Of<br>Week', 'TimeSlot', 'DaysOfWeek'],
    ':r_03' => ['Start<br>Time', 'TimeSlot', 'StartTime'],
    ':r_04' => ['End<br>Time', 'TimeSlot', 'EndTime'],
]);

$g->showGrid();