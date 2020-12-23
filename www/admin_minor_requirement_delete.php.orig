<?php
include_once '../models/MinorRequirements.php';

$minor_requirement = new MinorRequirements();
$minor_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $minor_name = $_GET['MinorName'];
    $course_id = $_GET['CourseID'];
    $old_course_id = $_GET['CourseID'];
    $minor_requirement_data = $minor_requirement->get([
        'MinorName' => $minor_name,
        'CourseID' => $course_id
    ]);
    $grade_requirement = $minor_requirement_data['GradeRequirement'];
} else {
    $minor_name = $_POST['MinorName'];
    $grade_requirement = $_POST['GradeRequirement'];
    $course_id = $_POST['CourseID'];
    $old_course_id = $_POST['OldCourseID'];
//    $course_id = substr($course_text, 0, strpos($course_text, ' ') + 1);
    $minor_requirement_data = $minor_requirement->get([
        'MinorName' => $minor_name,
        'CourseID' => $course_id
    ]);
}

$minor_requirement->delete([
    'MinorName' => $minor_name,
    'CourseID' => $course_id
]);

header("Location: admin_minor_edit.php?MinorName={$minor_name}");
exit;