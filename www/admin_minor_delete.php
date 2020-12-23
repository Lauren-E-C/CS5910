<?php
include_once '../models/Minor.php';

$minor = new Minor();

$minor_name = $_GET['MinorName'];

$minor->delete([
    'MinorName' => $minor_name
]);

header("Location: admin_minor_grid.php");
exit;