<?php
include_once 'instructor_manage_student_header.php';

$term_form = new Form("get");

$class_list = new ClassList();
$terms = $class_list->getUnique('TermNumber', [
    'StudentID' => $student_id
]);

$term_field = new SelectField("Term", $terms);
$student_field = new HiddenField("StudentID", $student_id);
$term_data = $term_form->showForm([
    'StudentID' => $student_field,
    'Term' => $term_field
]);

if (isset($_GET['Term'])) {
    $term = $term_data['Term'];
    $year = substr($term, -4, 4);
    $semester = substr($term, 0, strlen($term) - 4);

    $grid = new Grid(new ClassList(), [
        'CourseRegistrationNumber' => 'CRN',
        ':r_01' => ['Instructor<br>First Name', 'Faculty', 'firstName'],
        ':r_02' => ['Instructor<br>Last Name', 'Faculty', 'lastName'],
        ':r_03' => ['Department', 'Course', 'departmentcode'],
        ':r_04' => ['Section Number', 'Section', 'SectionNumber'],
        ':r_05' => ['Course Number', 'Section', 'CourseID'],
        ':r_06' => ['Course Name', 'Course', 'coursename'],
        ':r_07' => ['Room', 'Section', 'RoomID'],
        ':r_08' => ['Days', 'TimeSlot', 'DaysOfWeek'],
        ':r_09' => ['Start Time', 'TimeSlot', 'StartTime'],
        ':r_10' => ['End Time', 'TimeSlot', 'EndTime'],
    ]);

    $grid->showGrid([
        'StudentID' => $student_id,
        'TermNumber' => $term
    ]);
}



include_once 'footer.php';

