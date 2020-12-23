<?php
$roles = ['Admin'];
$page_title = "Section Edit";
include_once 'header.php';
include_once 'building_room.php';

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

// -- Semester Field
$semester_field = new SelectField('Semester', ['Fall', 'Winter', 'Spring', 'Summer']);

// -- Year field
$year_field = new SelectField('Year', ['2020', '2021', '2022', '2023', '2024', '2025']);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $crn = $_GET['CourseRegistrationNumber'];
} else {
    $crn = $_POST['CourseRegistrationNumber'];
}
?>

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
                        <a href="admin_section_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
            <li class="navbar-nav nav-item dropdown">
                <a class="btn btn-danger nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Delete</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="admin_section_delete.php?CourseRegistrationNumber=<?= $crn ?>">Confirm Delete</a>
                </div>
            </li>
        </nav>


    </div>
    <hr>
<?php

$f = new Form();

$section = new Section();
$section_record = $section->get([
    'CourseRegistrationNumber' => $crn
]);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $building = new Building();
    $building_name = $section_record['BuildingName'];
    $building_record = $building->get(['BuildingName' => $building_name]);
    $building_id = $building->getValue('BuildingIDNumber');
    $room_id = $section_record['RoomID'];
    $section_record['BuildingIDNumber'] = $building_id;

//    echo "<pre>";
//    var_dump($section_record);
//    echo "</pre>";

    list($building_field, $room_field) = building_room($room_id);

    $f->setValues($section_record);
} else {
    list($building_field, $room_field) = building_room();
}
// -- Build & room selects

$section_form_data = $f->showForm([
    'CourseRegistrationNumber' => new ReadOnlyField('Course Registration Number'),
    'SectionNumber' => 'Section Number',
    'CourseID' => $course_field,
    'FacultyID' => $faculty_field,
    'TimeSlotNum' => $time_slot_field,
    'SeatsCapacity' => 'Seats Capacity',
    'BuildingIDNumber' => $building_field,
    'RoomID' => $room_field,
    'Semester' => $semester_field,
    'Year' => $year_field
]);

if (isset($_GET['save'])) {

    $building = new Building();
    $building_id = $section_form_data['BuildingIDNumber'];
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

    $section = new Section();
    if ($section->get([
        'FacultyID' => $section_form_data['FacultyID'],
        'TimeSlotNum' => $section_form_data['TimeSlotNum'],
        'Semester' => $section_form_data['Semester'],
        'Year' => $section_form_data['Year'],
    ])) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">Instructor already schedule for a class during this time</div>
        </div>
        <?php
        exit;
    }

    if ($section->get([
        'TimeSlotNum' => $section_form_data['TimeSlotNum'],
        'BuildingName' => $building_name,
        'RoomID' => $section_form_data['RoomID'],
        'Semester' => $section_form_data['Semester'],
        'Year' => $section_form_data['Year'],
    ])) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">Room already schedule for a class during this time</div>
        </div>
        <?php
        exit;
    }

    try {
        $section = new Section();
        $section->get([
            'CourseRegistrationNumber' => $crn
        ]);
        $section->update($section_record);
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
        <div class="alert alert-success" role="alert">Section updated successful</div>
    </div>
    <?php
}