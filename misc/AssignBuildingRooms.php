<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'BuildingRoomUnique.php';

function randomDate($start_date, $end_date)
{
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d', $val);
}

echo "Count: " . count($BuildingRooms) . "\n";

$hostname = 'localhost';
$database = 'u684207109_cs5910';
$username = 'u684207109_cs5910';
$password = 'cs5910P@ssw0rd';

$dsn = "mysql:host=" . $hostname . ";dbname=" . $database . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//                PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_EMULATE_PREPARES => true,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    throw new PDOException("ERROR:" . $e->getMessage(), (int)$e->getCode());
}

$select_stmt = $pdo->prepare("select FacultyID from Faculty where BuildingID = 4", $options);
$x = $select_stmt->execute();

while ($row = $select_stmt->fetch()) {
    $faculty_id = $row['FacultyID'];

    $i = array_rand($BuildingRooms, 1);
    list($building_name, $building_id, $room_id) = $BuildingRooms[$i];

    $date = randomDate('2018-01-01', '2020-11-30');

    var_dump($date);

    try {
        $update_stmt = $pdo->prepare("update Faculty set BuildingID = :building_id, RoomId = :room_id, DateAssigned = :date where FacultyID = :faculty_id", $options);
        $update_stmt->execute([
            ':building_id' => $building_id,
            ':room_id' => $room_id,
            ':date' => $date,
            ':faculty_id' => $faculty_id
        ]);
    } catch (PDOException $e) {
        throw new PDOException("ERROR:" . $e->getMessage(), (int)$e->getCode());
    }
}
