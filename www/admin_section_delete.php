<?php
include_once '../models/Section.php';

$section = new Section();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $crn = $_GET['CourseRegistrationNumber'];
} else {
    $crn = $_POST['CourseRegistrationNumber'];
}

$prerequisite_record = $section->get([
    'CourseRegistrationNumber' => $crn,
]);

$section->delete([
    'CourseRegistrationNumber' => $crn,
]);

header("Location: admin_section_grid.php");
exit;