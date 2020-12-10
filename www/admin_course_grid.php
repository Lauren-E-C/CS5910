<?php
$roles = ['Admin'];
$page_title = "Course Maintenance";
include_once 'header.php';

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
                        <a href="admin_course_add.php" class="btn btn-success my-2 my-sm-0">Add Course</a>
                    </li>
                </ul>
            </nav>
        </nav>
<?php

$course = new Course();  // create new instance of a course model

// create am instance of a "grid" to make an html table
$g = new Grid($course, [
    'departmentcode' => 'Department ID',
    'courseID' => 'Course ID',
    'coursename' => 'Course Name',
    'level' => 'Level',
    'prerequisites' => 'Prerequisites',
    'credits' => 'Credits'
]);

// tell grid to go to admin_course_edit.php when a row is clicked
$g->setOnclickPage('admin_course_edit.php');

// tell grid to render html to make a bootstrap table
$g->showGrid();