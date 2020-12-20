<?php
include_once '../models/Prerequisites.php';

$prerequisite = new Prerequisites();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $course_id = $_GET['CourseID'];
    $preq_course_id = $_GET['PreqCourseID'];
} else {
    $course_id = $_POST['CourseID'];
    $preq_course_id = $_POST['PreqCourseID'];
}

$prerequisite_record = $prerequisite->get([
    'CourseID' => $course_id,
    'PreqCourseID' => $preq_course_id
]);

$prerequisite->delete([
    'CourseID' => $course_id,
    'PreqCourseID' => $preq_course_id
]);

header("Location: admin_course_edit.php?courseID=<?= $course_id ?>");
exit;