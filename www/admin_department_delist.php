<?php

include_once '../models/Department.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $department_id = $_GET['DepartmentID'];
} else {
    $department_id = $_POST['DepartmentID'];
}

$department = new Department();  // create new instance of a department model

$department_record = $department->get([
    'DepartmentID' => $department_id   // fetch the department record based on the department id
]);

$department_listed = $department->getValue('listed');

$listed = 'Y';
if ($department_listed == 'Y') {
    $listed = 'N';
}

try {
    $department->update([
        'listed' => $listed
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
}

header("Location: admin_department_edit.php?DepartmentID=$department_id");
exit;