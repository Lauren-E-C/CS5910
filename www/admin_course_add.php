<?php
$roles = ['Admin'];
$page_title = "Course Add";
include_once 'header.php';

// -- department field
$department = new Department();  // create model to get access to the "Department" table
$department_values = $department->getKeyValues('DepartmentID','DepartmentName');
$department_field = new KeyValueField('Department', $department_values);

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

            </nav>
        </nav>
    </div>
    <hr>
<?php

// -- create a new instance of a form object
$f = new Form();

// render the form to the browser
$course_form_data = $f->showForm([
    'courseID' => new TextField('Course ID'),
    'coursenumber' => new TextField('Course Number'),
    'departmentcode' => $department_field,
    'coursename' => new TextField('Course Name'),
    'description' => new TextAreaField('Prerequisite'),
    'level' => 'Level', // new TextField('Level')
    'credits' => 'Credits', // new TextField('Credits')
    'prerequisites' => 'Prerequisites', // new TextField('Prerequisites')
]);

// if the user clicked submit, then try to upddate the record with values from the form
if (isset($_GET['save'])) {
    try {
        $course = new Course();
        $course->create($course_form_data);
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
        <div class="alert alert-success" role="alert">Course create successful</div>
    </div>
    <?php
}
