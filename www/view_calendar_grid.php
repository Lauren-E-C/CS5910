<?php
$roles = null;
$page_title = "Academic Calendar";
include_once 'header.php';

?>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


        </nav>
    </div>
<?php

$g = new Grid(new AcademicCalendar(), [
    //'ID' => 'Event ID',
    'Date' => 'Date',
    'Event' => 'Event',
    'Term' => 'Term',
]);

$academic_calendar = new AcademicCalendar();
$academic_calendar_values = $academic_calendar->getUnique('Term');

$f = new Form();
$academic_calendar_form_data = $f->showForm([
    'Term' => new SelectField('Term', $academic_calendar_values)
]);

$term = $academic_calendar_values[0];
if ($academic_calendar_form_data) {
    $term = $academic_calendar_form_data['Term'];
}

$f->setValues([
    'Term' => $term
]);

//$g->setOnclickPage('admin_calendar_edit.php');
$g->showGrid([
    'Term' => $term
]);