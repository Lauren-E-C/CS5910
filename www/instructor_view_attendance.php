<?php
$roles = ['Instructor'];
$page_title = "View Attendance";
include_once 'header.php';

$class_list = new ClassList(); // create model
$class_list_row = $class_list->get([
    'FacultyID' => $_SESSION["u_data"]["ID"]
]);

$section_array = array();
while ($class_list_row) {
    $crn = $class_list->getValue('CourseRegistrationNumber');
    $course_name = $class_list->getValue('coursename', 'Course');

    $section_array[$class_list->getValue('CourseRegistrationNumber')] = $class_list->getValue('CourseRegistrationNumber') . ' - ' . $class_list->getValue('coursename', 'Course');

    $class_list_row = $class_list->next();
}

$f = new Form("get");

$form_data = $f->showForm([
    "Course" => new SelectField("Course", $section_array),
    'Date' => new DateField()
]);

if ($form_data) {
    $crn = substr($form_data['Course'],0, 5);
    $date = $form_data['Date'];

    $g = new Grid(new Attendance(), [
        ':r_01' => ['First<br>Name', 'Student', 'firstName'],
        ':r_02' => ['Last<br>Name', 'Student', 'lastName'],
        'Status' => 'Attendance<br>Status'
    ]);

    $g->showGrid([
        'Date' => $date,
        'CourseRegistrationNumber' => $crn
    ]);
}
