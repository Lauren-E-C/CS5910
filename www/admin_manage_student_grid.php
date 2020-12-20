<?php
$roles = ['Admin'];
$page_title = "Manage Students";
include_once 'header.php';

$filter = [
    'uType' => 'Student'
];


$grid = new Grid(new StudentHoldView(), [
    'ID' => 'Student<br>ID',
    'firstName' => 'First<br>Name',
    'lastName' => "Last<br>Name",
    'HoldName' => 'Hold<br>Name'
]);

$f1 = new Form();
$f2 = new Form();

$serach_form_data1 = $f1->showForm([
    'StudentID' => 'Student ID',
    'lastName' => new HiddenField('lastName', null)
]);

$serach_form_data2 = $f2->showForm([
    'StudentID' => new HiddenField('StudentID', null),
    'lastName' => 'Last Name'
]);

$student_id = $f1->getValues(['StudentID'])['StudentID'];
$last_name = $f1->getValues(['lastName'])['lastName'];

if ($student_id) {
    $filter['ID'] = '%' . $student_id;
}

if ($last_name) {
    $filter['lastName'] = '%' . $last_name;
}

$grid->setOnclickPage('admin_manage_student_register.php');
$grid->showGrid($filter);

include_once 'footer.php';