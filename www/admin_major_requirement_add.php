<?php
$roles = ['Admin'];
$page_title = "Add Major Requirement";
include_once 'header.php';

$course = new Course();
$courses = $course->getKeyValues('courseID', 'coursename');

$f = new Form();
$major_name = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $major_name = $_GET['MajorName'];
} else {
    $major_name = $f->getValues(['MajorName'])['MajorName'];
}

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
                        <a href="admin_major_edit.php?MajorName=<?= $major_name ?>"
                           class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
    <hr>
<?php



$major_requirement_data = $f->showForm([
    'MajorName' => new HiddenField('MajorName', $major_name),
    'Course' => new KeyValueField('Course', $courses),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $major_requirement = new MajorRequirements();
    $course_id = $major_requirement_data['Course'];
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
