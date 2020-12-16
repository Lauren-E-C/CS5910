<?php
$roles = ['Admin'];
$page_title = "Event Maintenance";
include_once 'header.php';

?>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="admin_calendar_add.php" class="btn btn-success my-2 my-sm-0">Add Event</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
<?php

$g = new Grid(new AcademicCalendar(), [
    //'ID' => 'Event ID',
    'Date' => 'Date',
    'Event' => 'Event',
    'Term' => 'Term',
]);

$g->setOnclickPage('admin_calendar_edit.php');
$g->showGrid();