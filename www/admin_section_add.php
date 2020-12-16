<?php
$roles = ['Admin'];
$page_title = "Section Add";
include_once 'header.php';

?>
    <script>
        function buildingChange(o) {
            console.log(o.value);
        }
    </script>
<?php

// -- course field
$course = new Course();  // create model to get access to the "course" table
$course_values = $course->getKeyValues('courseID', 'coursename');
$course_field = new KeyValueField('Course', $course_values);


// -- Instructor field
$users = new Users();
$user_values = $users->getKeyValues('ID', 'email', [
    'uType' => 'Instructor'
]);
$faculty_field = new KeyValueField('Instructor', $user_values);

// -- Time Slot Field
$time_slot = new TimeSlot();
$time_slot_values = $time_slot->getKeyValues('ID', null);
$time_slot_field = new KeyValueField('Time Slot', $time_slot_values);

// -- Building Field
$building = new Building();
$building_values = $building->getKeyValues('BuildingIDNumber', 'BuildingName');
$building_field = new KeyValueField('Building', $building_values);
$building_field->setOnChange('buildingChange');

// -- Room field
$room_field = new KeyValueField('Room', ['' => '']);

// -- Semester Field
$semester_field = new SelectField('Semester', ['Fall', 'Winter', 'Spring', 'Summer']);

// -- Year field
$year_field = new SelectField('Year', ['2021', '2022']);

// -- get the rooms for each build
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
            var rooms = building_rooms[o.value];

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

    <!--Navigation Bar-->

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
                        <a href="admin_course_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
    <hr>
<?php

$f = new Form();

$section = new Section();
$section_record = $section->getMax('CourseRegistrationNumber');
$crn = $section_record['max'] + 1;

$f->setValues([
    'CourseRegistrationNumber' => $crn
]);

$section_form_data = $f->showForm([
    'CourseRegistrationNumber' => new ReadOnlyField('Course Registration Number'),
    'SectionNumber' => 'Section Number',
    'FacultyID' => $faculty_field,
    'TimeSlotNum' => $time_slot_field,
    'SeatsCapacity' => 'Seats Capacity',
    'BuildingIDNumber' => $building_field,
    'RoomID' => $room_field,
    'Semester' => $semester_field,
    'Year' => $year_field
]);

if (isset($_GET['save'])) {

    $build_id = $section_form_data['BuildingIDNumber'];
    $building_record = $building->get(['BuildingIDNumber' => $building_id]);
    $building_name = $building->getValue('BuildingName');

    $section_record = [
        'CourseRegistrationNumber' => $section_form_data['CourseRegistrationNumber'],
        'CourseID' => $section_form_data['CourseID'],
        'SectionNumber' => $section_form_data['SectionNumber'],
        'FacultyID' => $section_form_data['FacultyID'],
        'TimeSlotNum' => $section_form_data['TimeSlotNum'],
        'SeatsCapacity' => $section_form_data['SeatsCapacity'],
        'BuildingName' => $building_name,
        'RoomID' => $section_form_data['RoomID'],
        'Semester' => $section_form_data['Semester'],
        'Year' => $section_form_data['Year'],
    ];

    try {
        $section = new Section();
        $section->create($section_record);
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
        <div class="alert alert-success" role="alert">Section create successful</div>
    </div>
    <?php
}