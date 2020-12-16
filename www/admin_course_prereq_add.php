<?php
$roles = ['Admin'];
$page_title = "Add Course Prerequisite";
include_once 'header.php';

$course = new Course();
$course_values = $course->getKeyValues('courseID', 'coursename');

$f = new Form();

$course_id = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    echo "get";
    $course_id = $_GET['courseID'];
} else {
    echo "post";
    $course_id = $_POST['courseID'];
}

print_r($course_id);
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
print_r($course_id);
$course_data = $f->showForm([
    'courseID' => new HiddenField('courseID', $course_id),
    'PreqCourseID' => new KeyValueField('PreqCourseID', $course_values),
    'GradeRequirement' => "Grade Requirement"
]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $prerequisite = new Prerequisites();
    try {
        $prerequisite->create([
            'CourseID' => $course_id,
            'PreqCourseID' => $course_data['PreqCourseID'],
            'GradeRequirement' =>  $course_data['GradeRequirement']
        ]);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Prerequisite created successfully.
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
