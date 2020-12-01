<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

$fin_csv = fopen($_SERVER['DOCUMENT_ROOT'] . "/misc/csv2/great_courses.txt", "r");
if (!$fin_csv) die("field to open file");

$systemUser = new Users();
$faulty = new Faculty();

$systemUserData = $systemUser->getMax("IDNumber");
$max = $systemUserData["max"];

if (!$max) {
    $system_user_id = 1;
}
else {
    $system_user_id = $max + 1;
}

while ($columns = fgetcsv($fin_csv)) {

    try {
        $faulty_names = preg_split("/ /", $columns[13]);

        $systemUserData = $systemUser->get([
            "FName" => $faulty_names[0],
            "LName" => $faulty_names[count($faulty_names)-1]
        ]);

        if ($systemUserData === false) {
            $r = [
                "IDNumber" => $system_user_id,
                "FName" => $faulty_names[0],
                "LName" => $faulty_names[count($faulty_names)-1],
                "UEmail" => $faulty_names[0] ."." . $faulty_names[count($faulty_names)-1] . "@lakeroyaluniversity.com",
                "ULocked" => 0,
                "UType" => 'Professor',
                "PhoneNum" => "2125551212"
            ];
            $systemUser->create($r);
            $system_user_id++;
        }
    }
    catch (Exception $e) {
        die($e->getMessage());
    }
}

