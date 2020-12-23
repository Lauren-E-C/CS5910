<?php
$roles = ['Admin'];
$page_title = "Section Maintenance";
include_once 'header.php';

// -- display nav bar
?>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="admin_section_add.php" class="btn btn-success my-2 my-sm-0">Add Section</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
<?php

$g = new Grid(new Section(),[
    'CourseRegistrationNumber' => 'CRN',
    'SectionNumber' => 'Section<br>Number',
    'CourseID' => 'Course ID',
    ':r_01' => ['Course<br>Name', 'Course', 'coursename'],

    'FacultyID' => 'Faculty<br>ID',
    ':r_02' => ['Faculty<br>First Name', 'Faculty', 'firstName'],
    ':r_03' => ['Faculty<br>Last Name', 'Faculty', 'lastName'],

    ':r_04' => ['Days Of<br>Week', 'TimeSlot', 'DaysOfWeek'],
    ':r_05' => ['Start<br>Time', 'TimeSlot', 'StartTime'],
    ':r_06' => ['End<br>Time', 'TimeSlot', 'EndTime'],

    'BuildingName' => 'Building<br>Name',
    'RoomID' => 'Room',
    'Semester' => 'Semester',
    'Year' => 'Year',
]);

$g->setOnclickPage('admin_section_edit.php');
$g->showGrid();