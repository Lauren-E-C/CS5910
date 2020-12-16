<?php

include_once '../models/Course.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $course_id = $_GET['courseID'];
} else {
    $course_id = $_POST['courseID'];
}

$course = new Course();  // create new instance of a course model

$course_record = $course->get([
    'courseID' => $course_id   // fetch the course record based on the course id
]);

$course_listed = $course->getValue('listed');

$listed = 'Y';
if ($course_listed == 'Y') {
    $listed = 'N';
}

try {
    $course->update([
        'listed' => $listed
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
}

header("Location: admin_course_edit.php?courseID=$course_id");
exit;