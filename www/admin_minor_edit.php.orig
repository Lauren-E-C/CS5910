<?php
$roles = ['Admin'];
$page_title = "Edit Minor";
include_once 'header.php';

// Department
$department = new Department();

$departments = array();
for ($department_record = $department->get(); $department_record; $department_record = $department->next()) {
    $departments[] = $department_record['DepartmentID'];
}

// Major
$major = new Major();

$majors = array();
for ($major_record = $major->get(); $major_record; $major_record = $major->next()) {
    $majors[] = $major_record['MajorName'];
}

// get minor record to be ediited
$minor_name = null;
if (isset($_GET['MinorName'])) {
    $minor_name = $_GET['MinorName'];
}
$minor = new Minor();
$minor_record = $minor->get([
    'MinorName' => $minor_name
]);

$minor_form = new Form();

if (!isset($_GET['save'])) {
    $minor_form->setValues($minor_record);
}
?>
    <hr>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="admin_minor_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>


                <li class="navbar-nav nav-item dropdown">
                    <a class="btn btn-danger nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Delete</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="admin_minor_delete.php">Confirm Delete</a>
                    </div>
                </li>
            </nav>
        </nav>
    </div>
    <hr>
<?php

$minor_data = $minor_form->showForm([
    'MinorName' => 'Minor Name',
    'DepartmentID' => new SelectField('Department', $departments),
    'MajorAffiliation' => new SelectField('Major Affiliation', $majors)
]);
?>
    <hr>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="admin_minor_requirement_add.php?MinorName=<?= $minor_name ?>"
                           class="btn btn-success my-2 my-sm-0">Add
                            Requirement</a>
                    </li>
                </ul>
            </nav>
    </div>
    <div class="container">
        <h3>Minor Requirements</h3>
        <?php
        $minor_req_grid = new Grid(new MinorRequirements(), [
            'MinorName' => 'Minor<br>Name',
            'CourseID' => 'Course ID',
            ':r_01' => ['Course Name', 'Course', 'coursename'],
            'GradeRequirement' => 'Grade<br>Requirement'
        ]);
        $minor_req_grid->setOnclickPage('admin_minor_requirement_edit.php');
        $minor_req_grid->showGrid([
            'MinorName' => $minor_name
        ]);
        ?>
    </div>
<?php

if ($minor_data && isset($_GET['save'])) {
    try {
        $minor->update($minor_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Minor updated successfully.
            </div>
        </div>
        <?php

    } catch (Exception $e) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                <?= $e->getMessage() ?>
            </div>
        </div>
        <?php
    }
}
