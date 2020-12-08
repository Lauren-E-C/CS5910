<?php
$roles = ['Admin'];
$page_title = "Add Minor";
include_once 'header.php';

$department = new Department();

$departments = array();
for ($department_record = $department->get(); $department_record; $department_record = $department->next()) {
    $departments[] = $department_record['DepartmentID'];
}

// Major
$major = new Major();

$majors = array();
for ($major_record = $major->get(); $major_record; $major_record = $major->next()) {
    $majors[] = $major_record['MajorName'];
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

$minor_data = $f->showForm([
    'MinorName' => 'Minor Name',
    'DepartmentID' => new SelectField('Department', $departments),
    'MajorAffiliation' => new SelectField('Major Affiliation', $majors)
]);

if ($minor_data) {
    $minor = new Minor();
    try {
        $minor->create($minor_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Minor created successfully.
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
