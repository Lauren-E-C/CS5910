<?php
$roles = ['Admin'];
$page_title = "Edit Course Prerequisite";
include_once 'header.php';

$course = new Course();
$course_values = $course->getKeyValues('courseID', 'coursename');

$f = new Form();

$course_id = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $course_id = $_GET['CourseID'];
    $preq_course_id = $_GET['PreqCourseID'];
} else {
    $course_id = $_POST['CourseID'];
    $preq_course_id = $_POST['PreqCourseID'];
}

$prerequisite = new Prerequisites();
$prerequisite_record = $prerequisite->get([
    'CourseID' => $course_id,
    'PreqCourseID' => $preq_course_id
]);

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
                        <a href="admin_course_edit.php?courseID=<?= $course_id ?>" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
    <hr>
<?php

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues($prerequisite_record);
}

$prerequisite_form_data = $f->showForm([
    'CourseID' => new HiddenField('CourseID', $course_id),
    'PreqCourseID' => new KeyValueField('PreqCourseID', $course_values),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $prerequisite->update([
            'CourseID' => $course_id,
            'PreqCourseID' => $prerequisite_form_data['PreqCourseID'],
            'GradeRequirement' => $prerequisite_form_data['GradeRequirement']
        ]);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Prerequisite updated successfully.
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
