<?php
include_once '../models/Major.php';

$major = new Major();

$major_name = $_GET['MajorName'];

$major->delete([
    'MajorName' => $major_name
]);

header("Location: admin_major_grid.php");
exit;