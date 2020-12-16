<?php
$roles = ['Instructor'];
$page_title = "Manage Students";
include_once 'header.php';

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
    'FacultyID' => $_SESSION["u_data"]["ID"]
]);

include_once 'footer.php';