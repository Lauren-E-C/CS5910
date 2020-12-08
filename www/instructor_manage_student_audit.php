<?php
include_once 'instructor_manage_student_header.php';

$student_holds = new StudentHolds();
$student_holds_record = $student_holds->get([
    'StudentID' => $student_id
]);
