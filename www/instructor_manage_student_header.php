<?php
$roles = ['Instructor'];
$page_title = "Manage Student";
include_once 'header.php';

// TODO: align navbar center

if (!isset($_GET['StudentID']) || !is_numeric($_GET['StudentID'])) {
    echo "<h1>Invalid student ID</h1>";
    exit;
}

$student_id = $_GET['StudentID'];

$student = new Users();
$student_record = $student->get([
    'ID' => $student_id
]);

// $_SERVER['SCRIPT_URL']
$manage_links = array(
        'instructor_manage_student_schedule.php' => 'Class Schedule',
        'instructor_manage_student_viewhold.php' => 'View Hold',
        'instructor_manage_student_transcript.php' => 'Unofficial Transcript',
        'instructor_manage_student_audit.php' => 'Degree Audit',
        'instructor_manage_student_program.php' => 'Student Program',
);

?>
<div class="d-flex justify-content-center">
    <?php foreach ($manage_links as $href => $text) {
        $selected = "btn btn-outline-primary";
        if ("/www/".$href == $_SERVER['SCRIPT_URL']) {
            $selected = "btn-primary";
        } ?>
    <a href="<?= $href ?>?StudentID=<?= $student_id ?>" class="btn <?= $selected ?> my-2 my-sm-0" style="margin: 2px;"><?= $text ?></a>
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