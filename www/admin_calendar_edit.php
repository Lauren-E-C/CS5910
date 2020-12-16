<?php
$roles = ['Admin'];
$page_title = "Edit Event";
include_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id = $_GET['ID'];
} else {
    $id = $_POST['ID'];
}

$calendar = new AcademicCalendar();
$calendar_reocrd = $calendar->get([
    'ID' => $id
]);
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
                        <a href="admin_calendar_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
    <hr>
<?php

$f = new Form();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues($calendar_reocrd);
}

$calendar_form_data = $f->showForm([
    'ID' => new ReadOnlyField('ID'),
    'Date' => new DateField('Date'),
    'Event' => new TextAreaField('Event'),
    'Term' => new SelectField('Term', [
        'Fall2020',
        'Winter2020',
        'Spring2020',
        'Summer2020',
        'Fall2021',
        'Winter2021',
        'Spring2021',
        'Summer2021',
    ])
]);

if (isset($_GET['save'])) {
    try {
        $calendar->update($calendar_form_data);
    } catch (Exception $e) {  // if error show the error message, then exit
        $msg = $e->getMessage();
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert"><?= $msg ?></div>
        </div>
        <?php
        exit;
    }
    ?>
    <div class="container">
        <div class="alert alert-success" role="alert">Event update successful</div>
    </div>
    <?php
}

