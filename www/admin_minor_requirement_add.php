<?php
$roles = ['Admin'];
$page_title = "Add Minor Requirement";
include_once 'header.php';

$course = new Course();

$courses = array();
for ($course_record = $course->get(); $course_record; $course_record = $course->next()) {
    $courses[] = $course_record['courseID'] . " - " . $course_record['coursename'];
}

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
        </nav>
    </div>
    <hr>
<?php

$minor_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $minor_name = $_GET['MinorName'];
} else {
    $minor_name = $f->getValues(['MinorName']);
}

$minor_requirement_data = $f->showForm([
    'MinorName' => new HiddenField('MinorName', $minor_name),
    'Course' => new SelectField('Course', $courses),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $minor_requirement = new MinorRequirements();
    $course = $minor_requirement_data['Course'];
    $course_id = substr($course, 0, strpos($course, ' ') + 1);
    try {
        $minor_requirement->create([
            'MinorName' => $minor_requirement_data['MinorName'],
            'CourseID' => $course_id,
            'GradeRequirement' =>  $minor_requirement_data['GradeRequirement']
        ]);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Minor Requirement created successfully.
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
