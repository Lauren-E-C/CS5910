<?php
$roles = ['Admin'];
$page_title = "Add Major";
include_once 'header.php';

$department = new Department();
$departments = $department->getKeyValues('DepartmentID', 'DepartmentName');

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

$major_data = $f->showForm([
    'MajorName' => 'Major Name',
    'DepartmentID' => new KeyValueField('Department', $departments),
    'TypeOfDegree' => new SelectField('Degree Type', ['Undergraduate', 'Graduate'])
]);

if ($major_data) {
    $major = new Major();
    try {
        $major->create($major_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Major created successfully.
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
