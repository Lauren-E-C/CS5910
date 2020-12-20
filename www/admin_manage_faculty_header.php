<?php
$roles = ['Admin'];
$page_title = "Manage Instructor";
include_once 'header.php';

// TODO: align navbar center
?>
<hr>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a href="admin_faculty_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                </li>
            </ul>
        </nav>
    </nav>
</div>
<hr>
<?php

if (!isset($_GET['ID']) || !is_numeric($_GET['ID'])) {
    echo "<h1>Invalid instructor ID</h1>";
    exit;
}

$student_id = $_GET['ID'];

$student = new Users();
$student_record = $student->get([
    'ID' => $student_id
]);

// $_SERVER['SCRIPT_URL']
$manage_links = array(
        'admin_manage_faculty_roster.php' => 'Roster',
        'admin_manage_faculty_schedule.php' => 'Schedule',
        'admin_manage_faculty_advising.php' => 'Advising',
        'admin_manage_faculty_attendance.php' => 'Take Attendance',
        'admin_manage_faculty_viewattendance.php' => 'View Attendance',
);

?>
<div class="d-flex justify-content-center">
    <?php foreach ($manage_links as $href => $text) {
        $selected = "btn btn-outline-primary";
        if ("/www/".$href == $_SERVER['SCRIPT_URL']) {
            $selected = "btn-primary";
        } ?>
    <a href="<?= $href ?>?ID=<?= $student_id ?>" class="btn <?= $selected ?> my-2 my-sm-0" style="margin: 2px;"><?= $text ?></a>
    <?php } ?>
</div>
<div class="container">
    <table class="table">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
        <tr>
            <td><?= $student_record['ID'] ?></td>
            <td><?= $student_record['firstName'] ?></td>
            <td><?= $student_record['lastName'] ?></td>
        </tr>
    </table>
</div>
<hr>