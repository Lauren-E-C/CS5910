<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/utils/init.php';
    echo "<h1>Hello, World!</h1>";

    $m = new TableName();
    $r = $m->get(
        ["column_1" => 456]
    );

    $m->update(["column_1" => 123]);

    for ($r = $m->get(["column_1" => [0,999]]); $r; $r = $m->next()) {
        print_r($r);
    }

    print_r($r);


//    $m->update(["column_1" => 456]);
//
//    $m->create(["column_1" => 789]);
}
catch (\Exception $e) {
    var_dump("Error: " . $e->getMessage());
}