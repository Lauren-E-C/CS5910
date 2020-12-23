<?php
$roles = ['Admin'];
$page_title = "Department Maintenance";
include_once 'header.php';

?>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="admin_department_add.php" class="btn btn-success my-2 my-sm-0">Add Department</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
<?php

$d = new Department();
//$d->setDebugger(true);

$g = new Grid($d, [
    'DepartmentID' => 'Department<br>ID',
    'DepartmentName' => 'Department<br>Name',

    // --
    ':r01' => ['Chair Person<br>First Name', 'Chairperson', 'firstName'],
    ':r02' => ['Chair Person<br>Last Name', 'Chairperson', 'lastName'],

    ':r03' => ['Manager<br>First Name', 'Manager', 'firstName'],
    ':r04' => ['Manager<br>Last Name', 'Manager', 'lastName'],

//    'BuildingName' => 'Building<br>Name',
    ':r05' => ['Building<br>Name', 'Building', 'BuildingName'],
    'RoomID' => 'Room<br>ID',
    'PhoneNumber' => 'Phone<br>Number',
    'Email' => 'E-Mail'
]);

$g->setOnclickPage('admin_department_edit.php');
$g->showGrid();