<?php
$roles = ['Admin'];
$page_title = "Edit Researcher";
include_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $student_id = $_GET['ID'];
} else {
    $student_id = $_POST['ID'];
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
                        <a href="admin_manage_researcher_grid.php" class="btn btn-success my-2 my-sm-0">Back</a>
                    </li>
                </ul>
            </nav>

            <li class="navbar-nav nav-item dropdown">
                <a class="btn btn-primary nav-link" style="color: white"
                   href="admin_researcher_popular_majors.php?ID=<?= $student_id ?>"
                   id="navbarDropdown"
                   role="button"
                   aria-haspopup="true" aria-expanded="false">Manage</a>
            </li>
        </nav>
    </div>
    <hr>
<?php



$faculty = new Users();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $faculty_record = $faculty->get([
        'ID' => $student_id,
        'uType' => 'Researcher'
    ]);
    $f->setValues($faculty_record);
}

$faculty_form_data = $f->showForm([
    'ID' => new HiddenField('ID', $student_id),
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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $faculty = new Users();
    $faculty_record = $faculty->get([
        'ID' => $student_id,
        'uType' => 'Instructor'
    ]);

    try {
        $faculty->update($faculty_form_data);
        ?>
        <div class="container">
            <div class="alert alert-success" role="alert">
                Researcher updated successfully.
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

?>

<?php include_once 'footer.php' ?>