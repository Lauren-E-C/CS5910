<?php
$roles = ['Admin'];
$page_title = "Add Major Requirement";
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
                        <a href="admin_major_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
    <hr>
<?php

$major_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $major_name = $_GET['MajorName'];
} else {
    $major_name = $f->getValues(['MajorName']);
}

$major_requirement_data = $f->showForm([
    'MajorName' => new HiddenField('MajorName', $major_name),
    'Course' => new SelectField('Course', $courses),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $major_requirement = new MajorRequirements();
    $course = $major_requirement_data['Course'];
    $course_id = substr($course, 0, strpos($course, ' ') + 1);
    try {
        $major_requirement->create([
            'MajorName' => $major_requirement_data['MajorName'],
            'CourseID' => $course_id,
            'GradeRequirement' =>  $major_requirement_data['GradeRequirement']
        ]);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Major Requirement created successfully.
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
