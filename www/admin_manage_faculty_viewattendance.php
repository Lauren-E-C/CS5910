<?php
include_once 'admin_manage_faculty_header.php';

$class_list = new ClassList(); // create model
$class_list_row = $class_list->get([
    'FacultyID' => $student_id
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
    'Date' => new DateField(),
    'ID' => new HiddenField('ID', $student_id)
]);

if (isset($form_data['Course'])) {
    $crn = substr($form_data['Course'],0, 5);
    $date = $form_data['Date'];

    $g = new Grid(new Attendance(), [
        ':r_01' => ['First<br>Name', 'Student', 'firstName'],
        ':r_02' => ['Last<br>Name', 'Student', 'lastName'],
        'Date' => 'Date',
        'Status' => 'Attendance<br>Status'
    ]);

    $g->showGrid([
        'Date' => $date,
        'CourseRegistrationNumber' => $crn
    ]);
}
