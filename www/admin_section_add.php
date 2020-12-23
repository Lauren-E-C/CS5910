<?php
$roles = ['Admin'];
$page_title = "Section Add";
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

// -- Build & room selects
list($building_field, $room_field) = building_room();
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
        </nav>
    </div>
    <hr>
<?php

$f = new Form();

$section = new Section();
$section_record = $section->getMax('CourseRegistrationNumber');
$crn = $section_record['max'] + 1;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues([
        'CourseRegistrationNumber' => $crn
    ]);
}

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