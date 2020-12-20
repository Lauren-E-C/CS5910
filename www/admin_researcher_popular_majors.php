<?php
include_once 'admin_manage_researcher_header.php';

$g = new Grid(new MajorCount(),[
    'MajorName' => 'Major',
    'MajorCount' => 'Popularity'
]);

$g->showGrid();