<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

$fin_csv = fopen($_SERVER['DOCUMENT_ROOT'] . "/misc/courses.csv", "r");

if (!$fin_csv) die("field to open file");

$course = new Course();
$user = new Users();
$room = new Room();
$building = new Building();
$faculty = new Faculty();
$timeslot = new TimeSlot();
$section = new Section();

while ($columns = fgetcsv($fin_csv)) {

    $column = $columns[10];
    $prefix = substr($column, 0, 3);
    if ($prefix == '100') continue;
    if ($prefix == 'Off') continue;
    if ($prefix == 'TBA') continue;

    $course_id = $columns[3];

    $courseData = $course->get(['coursenumber' => $course_id]);
    if ($courseData === false) {
        echo 'Course not found:' . $course_id . "\n";
        continue;
    }

    $faculty_names = preg_split("/ /", $columns[13]);
    $user_email = $faculty_names[0] . "." . $faculty_names[count($faculty_names) - 1] . "@lakeroyaluniversity.com.com";
    $userData = $user->get(['email' => $user_email]);
    if ($userData === false) {
        echo 'User not found:' . $user_email . "\n";
        continue;
    }

    $roomID = substr(strrchr($columns[10], " "), 1);
    $buildingName = substr($columns[10], 0, strrpos($columns[10], " "));

    $buildingData = $building->get([
        'BuildingName' => $buildingName
    ]);
    if ($buildingData === false) throw new Exception('building missing:' . $buildingName);

    $roomData = $room->get([
        'RoomID' => $roomID,
        'BuildingIDNumber' => $building->getValue("BuildingIDNumber"),
    ]);
    if ($roomData === false) throw new Exception('room missing:' . $roomID);

    $r = [
        'FacultyID' => $userData['ID'],
        'RoomID' => $roomID,
        'DepartmentID' => $columns[2],
        'TimeInDepartment' => '13:00:00'
    ];

    $facultyData = $faculty->get($r);
    if ($facultyData === false) {
        $faculty->create($r);
    }

    $timeslotID = NULL;
    $time_string = $columns[8];
    if ($time_string != 'TBA') {
        $days_of_week = $columns[9];

        list($start_time, $end_time) = preg_split("/ - /", $time_string);

        $start_time = $timeslot->parseTime($start_time);
        $end_time = $timeslot->parseTime($end_time);

        $timeslotData = $timeslot->get([
            'DaysOfWeek' => $days_of_week,
            'StartTime' => $start_time,
            'EndTime' => $end_time
        ]);
        if ($timeslotData === false) throw new Exception('timeslotData missing:' . $days_of_week);
        $timeslotID = $timeslotData['ID'];
    }

    $sectionData = $section->get([
        'CourseRegistrationNumber' => $columns[1]
    ]);

    if ($sectionData === false) {
        $section->create([
            'CourseRegistrationNumber' => $columns[1],
            "CourseID" => $course_id,
            'SectionNumber' => $columns[4],
            "FacultyID" => $userData['ID'],
            "RoomID" => $roomID,
            "BuildingName" => $buildingName,
            "SeatsCapacity" => 30,
            "Semester" => "Spring",
            "Year" => 2021, // TODO: change for future runs
            "TimeSlotNum" => $timeslotID
        ]);
    }
    else echo "crn found". $columns[1] . "\n";


//    try {
//        $r = [
//            "CourseID" => $columns[3],
//            "DepartmentID" => $columns[2],
//            "CourseDescription" => $columns[0],
//            "CourseName" => $columns[0],
//            "GraduateType" => $columns[5],
//            "Credits" => $columns[6]
//        ];
//
//
//        $courseModel->create($r);
//
//        $faculty_names = preg_split("/ /", $columns[13]);
//
//        if (!isset($faculty_members[$columns[13]])) {
//            $faculty_members[$columns[13]] = $faculty_count++;
//            $faculty_id = $faculty_members[$columns[13]];
//            $r = [
//                "IDNumber" => $faculty_id,
//                "FName" => $faculty_names[0],
//                "LName" => $faculty_names[count($faculty_names)-1],
//                "UEmail" => $faculty_names[0] ."." . $faculty_names[count($faculty_names)-1] . "@lakeroyaluniversity.com",
//                "ULocked" => 0,
//                "UType" => 'Professor',
//                "PhoneNum" => "2125551212"
//            ];
//            $systemUser->create($r);
//        }
//        $faculty_id = $faculty_members[$columns[13]];
//
//        $key = $columns[8];
//        if (!isset($time_slots[$key])) {
//            $time_slots[$key] = $time_slot_count++;
//
//        }
//
//        $r = [
//            'CourseRegistrationNumber' => $columns[1],
//            "CourseID" => $columns[3],
//            'SectionNumber' => $columns[4],
//            "facultyID" => $faculty_id,
//        ];
//
//    }
//    catch (Exception $e) {
//        die($e->getMessage());
//    }
}