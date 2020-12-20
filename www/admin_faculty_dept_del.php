<?php

include_once '../models/Faculty.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $faculty_id = $_GET['FacultyID'];
    $department_id = $_GET['DepartmentID'];
} else {
    $faculty_id = $_POST['FacultyID'];
    $department_id = $_POST['DepartmentID'];
}

$faculty = new Faculty();
$faculty->delete([
    'FacultyID' => $faculty_id,
    'DepartmentID' => $department_id
]);

header("Location: admin_faculty_edit.php?ID=$faculty_id");
exit;