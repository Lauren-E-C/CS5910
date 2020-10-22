<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

$fin_csv = fopen($_SERVER['DOCUMENT_ROOT'] . "/misc/courses.csv", "r");

if (!$fin_csv) die("field to open file");

$courseModel = new Course();
$systemUser = new SystemUsers();
$i = 0;

$faulty_members = array();
$faulty_count=1;

$time_slots = array();
$time_slot_count = 1;

$room_id = 1;

while ($columns = fgetcsv($fin_csv)) {

    try {
        $r = [
            "CourseID" => $columns[3],
            "DepartmentID" => $columns[2],
            "CourseDescription" => $columns[0],
            "CourseName" => $columns[0],
            "GraduateType" => $columns[5],
            "Credits" => $columns[6]
        ];
        $courseModel->create($r);

        $faulty_names = preg_split("/ /", $columns[13]);

        if (!isset($faulty_members[$columns[13]])) {
            $faulty_members[$columns[13]] = $faulty_count++;
            $faulty_id = $faulty_members[$columns[13]];
            $r = [
                "IDNumber" => $faulty_id,
                "FName" => $faulty_names[0],
                "LName" => $faulty_names[count($faulty_names)-1],
                "UEmail" => $faulty_names[0] ."." . $faulty_names[count($faulty_names)-1] . "@lakeroyaluniversity.com",
                "ULocked" => 0,
                "UType" => 'Professor',
                "PhoneNum" => "2125551212"
            ];
            $systemUser->create($r);
        }
        $faulty_id = $faulty_members[$columns[13]];

        $key = $columns[8];
        if (!isset($time_slots[$key])) {
            $time_slots[$key] = $time_slot_count++;

        }

        $r = [
            'CourseRegistrationNumber' => $columns[1],
            "CourseID" => $columns[3],
            'SectionNumber' => $columns[4],
            "FaultyID" => $faulty_id,
        ];

    }
    catch (Exception $e) {
        die($e->getMessage());
    }
}