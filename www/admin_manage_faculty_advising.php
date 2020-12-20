<?php
include_once 'admin_manage_faculty_header.php';

$advisor = new Advisor();

$grid = new Grid(new Advisor(),[
    ':r_01' => ['ID', 'Student', 'ID'],
    ':r_02' => ['First<br>Name', 'Student', 'firstName'],
    ':r_03' => ['Last<br>Name', 'Student', 'lastName'],
    'AssignedDate' => 'Assigned',
    ':r_04' => ['Hold Status', 'StudentHolds', 'HoldName']
]);

$grid->setOnclickPage('instructor_manage_student_schedule.php');

$grid->showGrid([
    'FacultyID' => $student_id
]);

include_once 'footer.php';