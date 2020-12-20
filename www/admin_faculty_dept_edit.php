<?php
$roles = ['Admin'];
$page_title = "Faculty Department Edit";
include_once 'header.php';
include_once 'building_room.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $faculty_id = $_GET['FacultyID'];
    $department_id = $_GET['DepartmentID'];
} else {
    $faculty_id = $_POST['FacultyID'];
    $department_id = $_POST['DepartmentID'];
}

list($building_field, $room_field) = building_room();

$listed = "Unassign Department";
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
                        <a href="admin_faculty_edit.php?ID=<?= $faculty_id ?>" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>

                <li class="navbar-nav nav-item dropdown">
                    <a class="btn btn-danger nav-link" style="color: white"
                       href="admin_faculty_dept_del.php?FacultyID=<?= $faculty_id ?>&DepartmentID=<?= $department_id ?>"
                       id="navbarDropdown"
                       role="button"
                       aria-haspopup="true" aria-expanded="false"><?= $listed ?></a>
                </li>
            </nav>
        </nav>
    </div>
    <hr>
<?php

# FacultyID=500417&DepartmentID=ACC

$f = new Form();

$department = new Department();
$department_values = $department->getKeyValues('DepartmentID', 'DepartmentName');

$faculty = new Faculty();
$faculty_record = $faculty->get([
    'FacultyID' => $faculty_id,
    'DepartmentID' => $department_id
]);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues($faculty_record);
}

$faculty_form_data = $f->showForm([
    'FacultyID' => new HiddenField('FacultyID', $faculty_id),
    'DepartmentID' => new KeyValueField('Department', $department_values),
    'BuildingID' => $building_field,
    'RoomID' => $room_field,
    'DateAssigned' => new DateField('Date Assigned')
]);

if (isset($_GET['save'])) {
    try {
        $faculty->update($faculty_form_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Faculty assignment updated successfully.
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