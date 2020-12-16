<?php
$roles = ['Admin'];
$page_title = "Department Add";
include_once 'header.php';

//// get department id from get post post variable
//if ($_SERVER['REQUEST_METHOD'] == "GET") {
//    $department_id = $_GET['DepartmentID'];
//} else {
//    $department_id = $_POST['DepartmentID'];
//}

$department = new Department();  // create new instance of a department model

//$department_record = $department->get([
//    'DepartmentID' => $department_id   // fetch the department record based on the department id
//]);

//echo "<pre>";
//print_r($department_record);
//echo "</pre>";die;

$listed = 'List';
$department_listed = $department->getValue('listed');
if ($department_listed == 'Y') {
    $listed = 'Delist';
}

// -- Building Field
$building = new Building();
$building_values = $building->getKeyValues('BuildingIDNumber', 'BuildingName');
$building_field = new KeyValueField('Building', $building_values);
$building_field->setOnChange('buildingChange');

// -- Room field
$room_field = new SelectField('Room', []);

// -- get the rooms for each building
$building = new Building();
$building_rooms = array();
$building_record = $building->get();
while ($building_record) {
    $building_id = $building->getValue('BuildingIDNumber');

    $building_rooms[$building_id] = array();
    $room = new Room();
    $room_record = $room->get([
        'BuildingIDNumber' => $building_id
    ]);

    while ($room_record) {
        $building_rooms[$building_id][] = $room->getValue('RoomID');
        $room_record = $room->next();
    }
    $building_record = $building->next();
}

?>
    <script>
        $( document ).ready(function() {
            console.log( "ready!" );

            var building_rooms = [];
            <?php
            echo "\n";
            foreach ($building_rooms as $building_key => $rooms) {
                echo "building_rooms[\"$building_key\"]= [";
                foreach ($rooms as $room) {
                    echo "\"$room\", ";
                }
                echo "];\n";
            }
            ?>

            var building_select = $('#BuildingID').get(0);
            var building_id = building_select.selectedOptions.item(0).value;

            console.log(building_id);
            console.log(building_rooms[building_id]);
            var rooms = building_rooms[building_id];

            var room_select = $('#RoomID').get(0);
            while (room_select.options.length > 0) {
                room_select.remove(room_select.options.length - 1);
            }

            for (i = 0; i < rooms.length; i++) {
                var opt = document.createElement('option');

                opt.text = rooms[i];
                opt.value = rooms[i];

                room_select.add(opt, null);
            }

        });

        function buildingChange(o) {
            var building_rooms = [];
            <?php
            echo "\n";
            foreach ($building_rooms as $building_key => $rooms) {
                echo "building_rooms[\"$building_key\"]= [";
                foreach ($rooms as $room) {
                    echo "\"$room\", ";
                }
                echo "];\n";
            }
            ?>
            var building_id = o.value;

            console.log(building_id);
            console.log(building_rooms[building_id]);
            var rooms = building_rooms[building_id];

            var room_select = $('#RoomID').get(0);
            while (room_select.options.length > 0) {
                room_select.remove(room_select.options.length - 1);
            }

            for (i = 0; i < rooms.length; i++) {
                var opt = document.createElement('option');

                opt.text = rooms[i];
                opt.value = rooms[i];

                room_select.add(opt, null);
            }
        }
    </script>

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
            </nav>
        </nav>
    </div>
    <hr>
<?php

// -- create a new instance of a form object
$f = new Form();

$chair = new Users();
$chair_values = $chair->getKeyValues('ID', 'email', [
    'uType' => 'Instructor'
]);

$manager = new Users();
$manager_values = $chair->getKeyValues('ID', 'email', [
    'uType' => 'Instructor'
]);

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
