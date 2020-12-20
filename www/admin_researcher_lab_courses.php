<?php
include_once 'admin_manage_researcher_header.php';


$g = new Grid(new LabCourses(),[
    'CourseID' => 'Course<br>ID',
    'coursename' => 'Course<br>Name',
    'LabCount' => 'Student<br>Count'
]);

$g->showGrid();