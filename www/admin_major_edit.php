<?php
$roles = ['Admin'];
$page_title = "Edit Major";
include_once 'header.php';

// Deppartment
$department = new Department();

$departments = array();
for ($department_record = $department->get(); $department_record; $department_record = $department->next()) {
    $departments[] = $department_record['DepartmentID'];
}

// get major record to be ediited
$major_name = null;
if (isset($_GET['MajorName'])) {
    $major_name = $_GET['MajorName'];
}
$major = new Major();
$major_record = $major->get([
    'MajorName' => $major_name
]);

$major_form = new Form();

if (!isset($_GET['save'])) {
    $major_form->setValues($major_record);
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
                        <a href="admin_major_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>


                <li class="navbar-nav nav-item dropdown">
                    <a class="btn btn-danger nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Delete</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="admin_major_delete.php">Confirm Delete</a>
                    </div>
                </li>
            </nav>
        </nav>
    </div>
    <hr>
<?php

$major_data = $major_form->showForm([
    'MajorName' => 'Major Name',
    'DepartmentID' => new SelectField('Department', $departments),
    'TypeOfDegree' => new SelectField('Degree Type', ['Undergraduate', 'Graduate'])
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
                        <a href="admin_major_requirement_add.php?MajorName=<?= $major_name ?>" class="btn btn-success my-2 my-sm-0">Add
                            Requirement</a>
                    </li>
                </ul>
            </nav>
    </div>
    <div class="container">
        <h3>Major Requirements</h3>
        <?php
        $major_req_grid = new Grid(new MajorRequirements(), [
            'MajorName' => 'Major<br>Name',
            'CourseID' => 'Course ID',
            ':r_01' => ['Course Name', 'Course', 'coursename'],
            'GradeRequirement' => 'Grade<br>Requirement'
        ]);
        $major_req_grid->setOnclickPage('admin_major_requirement_edit.php');
        $major_req_grid->showGrid([
            'MajorName' => $major_name
        ]);
        ?>
    </div>
<?php

if ($major_data && isset($_GET['save'])) {
    try {
        $major->update($major_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Major updated successfully.
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
