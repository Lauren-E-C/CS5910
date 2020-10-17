<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/utils/init.php';
    echo "<h1>Hello, World!</h1>";

    $m = new TableName();
    $m->get(123);
    $m->update(["column_1" => 456]);
}
catch (\Exception $e) {
    var_dump("Error: " . $e->getMessage());
}