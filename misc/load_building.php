<?php

$base_dir = ".";

if (isset($_SERVER['DOCUMENT_ROOT'] )) {
    $base_dir = $_SERVER['DOCUMENT_ROOT'];
}

require_once $base_dir . '/utils/init.php';

$fin_csv = fopen($base_dir . "/misc/csv2/great_courses.txt", "r");

if (!$fin_csv) die("field to open file");

$room = new Room();
$building = new Building();

$buildingData = $building->getMax("BuildingIDNumber");
$max = $buildingData["max"];

if (!$max) {
    $building_id = 1;
}
else {
    $building_id = $max + 1;
}

//    [100% web, no face to face ] => 1
//    [Off Campus ] => 1
//    [TBA] => 1

while ($columns = fgetcsv($fin_csv)) {

    if (!isset($columns[10])) {
        print_r($columns);
        continue;
    }

    $column = $columns[10];
    $prefix = substr($column, 0, 3);
    if ($prefix == '100') continue;
    if ($prefix == 'Off') continue;
    if ($prefix == 'TBA') continue;

    $roomID = substr(strrchr($column, " "), 1);
    $buildingName = substr($column, 0, strrpos($column, " "));

//    echo "column:";
//    print_r($columns);

    // look for building by name
    $buildingData = $building->get([
        'BuildingName' => $buildingName
    ]);

    // if not exist, then add it
    if ($buildingData === false) {
        echo "Adding building: $buildingName<br>\n";
        $building->create([
            'BuildingIDNumber' => $building_id,
            'BuildingName' => $buildingName
        ]);
        $building_id++;
    } else {
        echo "Building exists: $buildingName<br>\n";
    }

    // look for room by room id and building id
    $roomData = $room->get([
        'RoomID' => $roomID,
        'BuildingIDNumber' => $building->getValue("BuildingIDNumber"),
    ]);

    if ($roomData == false) {
        echo "Adding room: $roomID\n";
        $room->create([
            'RoomID' => $roomID,
            'BuildingIDNumber' => $building->getValue("BuildingIDNumber"),
            'RoomSize' => 32,
            'RoomType' => $columns[12]
        ]);
    }
}

