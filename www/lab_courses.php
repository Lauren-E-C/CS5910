<?php
$roles = ['Researcher'];
$page_title = "Lab Courses";
include 'header.php';


$g = new Grid(new LabCourses(),[
    'CourseID' => 'Course<br>ID',
    'coursename' => 'Course<br>Name',
    'LabCount' => 'Student<br>Count'
]);

$g->showGrid();