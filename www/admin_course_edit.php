<?php
$roles = ['Admin'];
$page_title = "Course Edit";
include_once 'header.php';

// -- department field
$department = new Department();
$department_field = new KeyValueField('Department', $department->getKeyValues('DepartmentID', 'DepartmentName'));

// -- get the record to be edited

// get course id from get post post variable
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $course_id = $_GET['courseID'];
} else {
    $course_id = $_POST['courseID'];
}

$course = new Course();  // create new instance of a course model

$course_record = $course->get([
    'courseID' => $course_id   // fetch the course record based on the course id
]);


// --- Show nav bar
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
                        <a href="admin_course_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>


                <li class="navbar-nav nav-item dropdown">
                    <a class="btn btn-danger nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Delete</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="admin_course_delete.php">Confirm Delete</a>
                    </div>
                </li>
            </nav>
        </nav>
    </div>
    <hr>
<?php

// -- create fields to be used in the form

$course_id_field = new TextField('Course ID');
$course_name_field = new TextField('Course Name');

// -- create a new instance of a form object
$f = new Form();

// if we arrive at this page from a "get" method, then use the data from the record for the form
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues($course_record);
}

// render the form to the browser
$course_form_data = $f->showForm([
    'courseID' => $course_id_field,
    'departmentcode' => $department_field,
    'coursename' => $course_name_field,
    'description' => new TextAreaField('Description'),
    'level' => 'Level', // new TextField('Level')
    'credits' => 'Credits', // new TextField('Credits')
    'prerequisites' => 'Prerequisites', // new TextField('Prerequisites')
]);

// if the user clicked submit, then try to upddate the record with values from the form
if (isset($_GET['save'])) {
    try {
        $course->update($course_form_data);
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
        <div class="alert alert-success" role="alert">Course update successful</div>
    </div>
    <?php
}
