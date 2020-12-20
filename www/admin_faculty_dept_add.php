<?php
$roles = ['Admin'];
$page_title = "Assign Faculty to Department";
include_once 'header.php';
include_once 'building_room.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $faculty_id = $_GET['ID'];
} else {
    $faculty_id = $_POST['FacultyID'];
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
            </nav>
        </nav>
    </div>
    <hr>
<?php

# FacultyID=500417&DepartmentID=ACC

$f = new Form();

$department = new Department();
$department_values = $department->getKeyValues('DepartmentID', 'DepartmentName');

$faculty_form_data = $f->showForm([
    'FacultyID' => new HiddenField('FacultyID', $faculty_id),
    'DepartmentID' => new KeyValueField('Department', $department_values),
    'BuildingID' => $building_field,
    'RoomID' => $room_field,
    'DateAssigned' => new DateField('Date Assigned')
]);

if (isset($_GET['save'])) {
    try {
        $faculty = new Faculty();
        $faculty->create($faculty_form_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Faculty assignment created successfully.
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