<?php
$roles = ['Admin'];
$page_title = "Department Edit";
include_once 'header.php';
include_once 'building_room.php';

// -- get the record to be edited

// get department id from get post post variable
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $department_id = $_GET['DepartmentID'];
} else {
    $department_id = $_POST['DepartmentID'];
}

$department = new Department();  // create new instance of a department model

$department_record = $department->get([
    'DepartmentID' => $department_id   // fetch the department record based on the department id
]);

//echo "<pre>";
//print_r($department_record);
//echo "</pre>";die;

$listed = 'List';
$department_listed = $department->getValue('listed');
if ($department_listed == 'Y') {
    $listed = 'Delist';
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
                        <a href="admin_department_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>

                <li class="navbar-nav nav-item dropdown">
                    <a class="btn btn-danger nav-link" style="color: white" href="admin_department_delist.php?DepartmentID=<?= $department_id ?>" id="navbarDropdown"
                       role="button"
                       aria-haspopup="true" aria-expanded="false"><?= $listed ?></a>
                </li>
            </nav>
        </nav>
    </div>
    <hr>
<?php

// -- create a new instance of a form object
$f = new Form();

// if we arrive at this page from a "get" method, then use the data from the record for the form
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues($department_record);
}

$chair = new Users();
$chair_values = $chair->getKeyValues('ID', 'email', [
    'uType' => 'Instructor'
]);

$manager = new Users();
$manager_values = $chair->getKeyValues('ID', 'email', [
    'uType' => 'Instructor'
]);

$room_id = $department_record['RoomID'];

//echo "<pre>";
//var_dump($room_id);
//echo "</pre>";

list($building_field, $room_field) = building_room($room_id);

// render the form to the browser
$department_form_data = $f->showForm([
    'DepartmentID' => 'Department ID',
    'DepartmentName' => 'Department Name',

    'ChairpersonID' => new KeyValueField('Chair Person', $chair_values),
    'ManagerID' => new KeyValueField('Department Manager', $manager_values),

    'BuildingID' => $building_field,
    'RoomID' => $room_field,

    'PhoneNumber' => 'Phone Number',
    'Email' => 'Email',
    'listed' => new ReadOnlyField('Listed')
]);

// if the user clicked submit, then try to upddate the record with values from the form
if (isset($_GET['save'])) {
    try {
        $department->update($department_form_data);
    } catch (Exception $e) {  // if error show the error message, then exit
        $msg = $e->getMessage();
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert"><?= $msg ?></div>
        </div>
        <?php
        exit;
    }
    ?>
    <div class="container">
        <div class="alert alert-success" role="alert">Department update successful</div>
    </div>
    <?php
}
