<?php
include_once '../models/MajorRequirements.php';

$major_requirement = new MajorRequirements();
$major_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $major_name = $_GET['MajorName'];
    $course_id = $_GET['CourseID'];
    $old_course_id = $_GET['CourseID'];
    $major_requirement_data = $major_requirement->get([
        'MajorName' => $major_name,
        'CourseID' => $course_id
    ]);
    $grade_requirement = $major_requirement_data['GradeRequirement'];
} else {
    $major_name = $_POST['MajorName'];
    $grade_requirement = $_POST['GradeRequirement'];
    $course_id = $_POST['CourseID'];
    $old_course_id = $_POST['OldCourseID'];
//    $course_id = substr($course_text, 0, strpos($course_text, ' ') + 1);
    $major_requirement_data = $major_requirement->get([
        'MajorName' => $major_name,
        'CourseID' => $course_id
    ]);
}

$major_requirement->delete([
    'MajorName' => $major_name,
    'CourseID' => $course_id
]);

header("Location: admin_major_edit.php?MajorName={$major_name}");
exit;