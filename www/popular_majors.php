<?php
$roles = ['Researcher'];
$page_title = "Major Popularity";
include 'header.php';


$g = new Grid(new MajorCount(),[
    'MajorName' => 'Major',
    'MajorCount' => 'Popularity'
]);

$g->showGrid();