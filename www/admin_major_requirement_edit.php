<?php
$roles = ['Admin'];
$page_title = "Edit Major Requirement";
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
                        <a href="admin_major_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>

            <li class="navbar-nav nav-item dropdown">
                <a class="btn btn-danger nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Delete</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="admin_major_delete.php">Confirm Delete</a>
                </div>
            </li>
        </nav>
    </div>
    <hr>
<?php

$course = new Course();
$courses = array();

$major_requirement = new MajorRequirements();
$major_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $major_name = $_GET['MajorName'];
    $course_id = $_GET['CourseID'];
    $major_requirement_data = $major_requirement->get([
        'MajorName' => $major_name,
        'CourseID' => $course_id
    ]);
    $grade_requirement = $major_requirement_data['GradeRequirement'];
} else {
    $major_name = $_POST['MajorName'];
    $grade_requirement = $_POST['GradeRequirement'];
    $course_text = $_POST['Course'];
    $course_id = substr($course_text, 0, strpos($course_text, ' ') + 1);
    $major_requirement_data = $major_requirement->get([
        'MajorName' => $major_name,
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
    'MajorName' => $major_name,
    'Course' => $current_course,
    'GradeRequirement' => $grade_requirement
]);

$major_requirement_data = $f->showForm([
    'MajorName' => new HiddenField('MajorName', $major_name),
    'Course' => new ReadOnlyField('Course'),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $course = $major_requirement_data['Course'];
    try {
        $major_requirement->update([
            'MajorName' => $major_requirement_data['MajorName'],
            'CourseID' => substr($course, 0, strpos($course, ' ') + 1),
            'GradeRequirement' => $major_requirement_data['GradeRequirement']
        ]);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Major Requirement updated successfully.
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
