<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/utils/init.php';
    echo "<h1>Hello, World!</h1>";

    $m = new SystemUsers();

//    $m->update(["column_1" => 123]);

    for ($r = $m->get(); $r; $r = $m->next()) {
        print_r($r);
    }


//    $m->update(["column_1" => 456]);
//
//    $m->create(["column_1" => 789]);
}
catch (\Exception $e) {
    var_dump("Error: " . $e->getMessage());
}