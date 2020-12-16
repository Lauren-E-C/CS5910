<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

$filename_in = "data/" . $_GET['file'];

$fd_in = fopen($filename_in, "r");

if ($fd_in === false) {
    die("Could not open $filename_in");
}

echo "<pre>\n";

echo "Filename opened: $filename_in\n";

$Coursename = null;
$CRN = null;
$Department = null;
$CourseID = null;
$Section = null;
$Level = null;
$Credits = null;
$Prerequisites = null;
$timeslot = null;
$Day = null;
$Location = null;
$Term = null;
$Roomtype = null;
$Instructor = null;
$Capacity = null;

$column_headers = [
    0 => 'Coursename',
    1 => 'CRN',
    2 => 'Department',
    3 => 'CourseID',
    4 => 'Section',
    5 => 'Level',
    6 => 'Credits',
    7 => 'Prerequisites',
    8 => 'timeslot',
    9 => 'Day',
    10 => 'Location',
    11 => 'Term',
    12 => 'Roomtype',
    13 => 'Instructor',
    14 => 'Capacity',
];

$header_names = array();

$header_in_columns = fgetcsv($fd_in);

if (count($header_in_columns) != 15) {
    die('Invalid length');
}

foreach ($column_headers as $index => $column_header) {
    $header_in_column = trim($header_in_columns[$index]);
    if ($index == 0) {
        $header_in_column = substr($header_in_column, 3);
    }

    if ($column_headers[$index] != $header_in_column) {
        var_dump($header_in_column);
        var_dump($column_headers[$index]);
        die("Headers do not match " . $column_headers[$index] . ' != ' . $header_in_column);
    }

    $header_names[$header_in_column] = $index;
    $$header_in_column = $index;
}

print_r($header_names);

$course = new Course();
$section_model = new Section();

while ($columns = fgetcsv($fd_in)) {
    $col_instructor = $columns[$Instructor];
    $faculty_id = process_faculty($col_instructor);

    $days_of_week = $columns[$Day];
    $time_string = $columns[$timeslot];
    $timeslot_id = process_timeslot($columns, $days_of_week, $time_string);

    $location = $columns[$Location];
    $roomtype = $columns[$Roomtype];
    list($building_name, $room_id) = process_location($location, $roomtype);

    $course_record = $course->get([
        'courseID' => $columns[$CourseID]
    ]);

    if (!$course_record) {
        echo "Creating course: " . $columns[$CourseID] . "\n";
        $course->create([
            'courseID' => $columns[$CourseID],
            'coursenumber' => $columns[$CourseID],
            'coursename' => $columns[$Coursename],
            'departmentcode' => $columns[$Department],
            'level' => $columns[$Level],
            'prerequisites' => $columns[$Prerequisites],
            'credits' => $columns[$Credits],
            'listed' => 'Y',
        ]);
    }

    $term_text = $columns[$Term];
    $semester = substr($term_text, 0, strlen($term_text) - 4);
    $year = substr($term_text, -4, 4);

    $r = [
        'CourseRegistrationNumber' => $columns[$CRN],
        'CourseID' => $columns[$CourseID],
        'SectionNumber' => $columns[$Section],
        'FacultyID' => $faculty_id,
        'TimeSlotNum' => $timeslot_id,
        'SeatsCapacity' => $columns[$Capacity],
        'RoomID' => $room_id,
        'BuildingName' => $building_name,
        'Semester'=> $semester,
        'Year' => $year
    ];

    $section_record = $section_model->get([
        'CourseRegistrationNumber' => $columns[$CRN]
    ]);

    if (!$section_record) {
        echo "Creating CRN: {$columns[$CRN]}\n";
        $section_model->create($r);
    } else {
        echo "Updating CRN: {$columns[$CRN]}\n";
        $section_model->update($r);
    }
}


function process_faculty($col_instructor)
{
    $users = new Users();

    $faulty_names = preg_split("/ /", $col_instructor);
    $first_name = $faulty_names[0];
    $last_name = $faulty_names[count($faulty_names) - 1];
    $email = $first_name . "." . $last_name . "@lakeroyaluniversity.com";

    $user_data = $users->get([
        'email' => $email
    ]);
    if (!$user_data) {
        echo "$col_instructor: $email - User not found.\n";
        $faculty_id = $users->getMax('ID')["max"];
        $faculty_id++;
        $users->create([
            'ID' => $faculty_id,
            'lastName' => $last_name,
            'firstName' => $first_name,
            'address' => 'NEW_USER',
            'email' => $email,
            'pWord' => 'Passsword1',
            'state' => 'Florida',
            'country' => 'United States of America',
            'uType' => 'Instructor',
            'uLocked' => 'No',
            'failedLogins' => 0
        ]);
        return $faculty_id;
    } else {
        return $users->getValue('ID');
    }
}

function process_timeslot($columns, $days_of_week, $time_string)
{
    if ($time_string == 'TBA') return null;
    if (preg_match('/TBA/', $time_string)) return null;

    $timeslot = new TimeSlot();

    list($start_time, $end_time) = preg_split("/ - /", $time_string);

//    echo "time_string: $time_string\n";

    $start_time = $timeslot->parseTime($start_time);
    $end_time = $timeslot->parseTime($end_time);

    $timeslot_data = $timeslot->get([
        'DaysOfWeek' => $days_of_week,
        'StartTime' => $start_time,
        'EndTime' => $end_time
    ]);

    if (!$timeslot_data) {
        echo "Time slot does not exists: ";
        $timeslot_id = $timeslot->getMax('ID')["max"];
        $timeslot_id++;

        print_r([
            'ID' => $timeslot_id,
            'DaysOfWeek' => $days_of_week,
            'StartTime' => $start_time,
            'EndTime' => $end_time
        ]);
        $timeslot->create([
            'ID' => $timeslot_id,
            'DaysOfWeek' => $days_of_week,
            'StartTime' => $start_time,
            'EndTime' => $end_time
        ]);
        return $timeslot_id;
    } else {
        return $timeslot->getValue('ID');
    }
}

function process_location($location, $roomtype)
{

    $prefix = substr($location, 0, 3);
    if ($prefix == '100') return array(null, null);
    if ($prefix == 'Off') return array(null, null);
    if ($prefix == 'TBA') return array(null, null);

    $roomID = substr(strrchr($location, " "), 1);
    $buildingName = substr($location, 0, strrpos($location, " "));

    $building = new Building();
    $room = new Room();

    // look for building by name
    $buildingData = $building->get([
        'BuildingName' => $buildingName
    ]);

    // if not exist, then add it
    $building_id = null;
    if ($buildingData === false) {
        $building_id = $building->getMax('BuildingIDNumber')["max"];
        $building_id++;
        echo "Adding building: $buildingName<br>\n";
        $building->create([
            'BuildingIDNumber' => $building_id,
            'BuildingName' => $buildingName
        ]);
    } else {
        $building_id = $building->getValue('BuildingIDNumber');
    }

    // look for room by room id and building id
    $roomData = $room->get([
        'RoomID' => $roomID,
        'BuildingIDNumber' => $building_id
    ]);

    if (!$roomData) {
        echo "Adding room: $roomID\n";
        $room->create([
            'RoomID' => $roomID,
            'BuildingIDNumber' => $building_id,
            'RoomSize' => 32,
            'RoomType' => $roomtype
        ]);
    }
    return [$buildingName, $roomID];
}

echo "</pre>\n";

