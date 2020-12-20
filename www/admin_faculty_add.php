<?php
$roles = ['Admin'];
$page_title = "Add Faculty";
include_once 'header.php';

$department = new Department();

$departments = array();
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
                        <a href="admin_faculty_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>
        </nav>
    </div>
    <hr>
<?php

$faculty_data = $f->showForm([
    ['firstName' => 'First Name',
        'lastName' => 'Last Name'],
    ['email' => 'E-Mail',
        'phoneNumber' => 'Phone Number'],
    'address' => 'Address',
    ['town' => 'City',
        'state' => 'State',
        'zip' => 'Zip Code'],
    'country' => 'Country',
]);

if ($faculty_data) {
    $users = new Users();
    try {
        $faculty_data['ID'] = null;
        $faculty_data['uType'] = 'Instructor';
        $users->create($faculty_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Faculty created successfully.
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
