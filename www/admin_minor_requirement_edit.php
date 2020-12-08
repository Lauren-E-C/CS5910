<?php
$roles = ['Admin'];
$page_title = "Edit Minor Requirement";
include_once 'header.php';

$f = new Form();
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
                        <a href="admin_minor_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>

            <li class="navbar-nav nav-item dropdown">
                <a class="btn btn-danger nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Delete</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="admin_minor_delete.php">Confirm Delete</a>
                </div>
            </li>
        </nav>
    </div>
    <hr>
<?php

$course = new Course();
$courses = array();

$minor_requirement = new MinorRequirements();
$minor_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $minor_name = $_GET['MinorName'];
    $course_id = $_GET['CourseID'];
    $minor_requirement_data = $minor_requirement->get([
        'MinorName' => $minor_name,
        'CourseID' => $course_id
    ]);
    $grade_requirement = $minor_requirement_data['GradeRequirement'];
} else {
    $minor_name = $_POST['MinorName'];
    $grade_requirement = $_POST['GradeRequirement'];
    $course_text = $_POST['Course'];
    $course_id = substr($course_text, 0, strpos($course_text, ' ') + 1);
    $minor_requirement_data = $minor_requirement->get([
        'MinorName' => $minor_name,
        'CourseID' => $course_id
    ]);
}

$current_course = "";
for ($course_record = $course->get(); $course_record; $course_record = $course->next()) {
    if ($course_record['courseID'] == $course_id) {
        $current_course = $course_record['courseID'] . " - " . $course_record['coursename'];
    }
    $courses[] = $course_record['courseID'] . " - " . $course_record['coursename'];
}

$f->setValues([
    'MinorName' => $minor_name,
    'Course' => $current_course,
    'GradeRequirement' => $grade_requirement
]);

$minor_requirement_data = $f->showForm([
    'MinorName' => new HiddenField('MinorName', $minor_name),
    'Course' => new ReadOnlyField('Course'),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $course = $minor_requirement_data['Course'];
    try {
        $minor_requirement->update([
            'MinorName' => $minor_requirement_data['MinorName'],
            'CourseID' => substr($course, 0, strpos($course, ' ') + 1),
            'GradeRequirement' => $minor_requirement_data['GradeRequirement']
        ]);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Minor Requirement updated successfully.
            </div>
        </div>
        <?php
    } catch (Exception $e) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                <?= $e->getMessage() ?>
            </div>
        </div>
        <?php
    }
}
