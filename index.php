<?php

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/utils/init.php';
    echo "<h1>Hello, World!</h1>";


    echo "<h2>DB 1:</h2>";
    $db = new Database();

    echo "<h2>DB 2:</h2>";
    var_dump($db);

    $stmt = $db->prepare("select * from table_name");
    $stmt->execute();
    $rows = $stmt->fetch();

    echo "<h2>Rows:</h2>";
    var_dump($rows);
}
catch (\Exception $e) {
    var_dump("Error: " . $e->getMessage());
}