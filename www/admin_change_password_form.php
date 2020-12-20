<?php
$roles = ['Admin'];
$page_title = "Change Password";
include_once 'header.php';

// TODO: align navbar center

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['ID'];
} else {
    $student_id = $_GET['ID'];
}

$student = new Users();
$student_record = $student->get([
    'ID' => $student_id
]);

?>
<div class="container">
    <table class="table">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
        <tr>
            <td><?= $student_record['ID'] ?></td>
            <td><?= $student_record['firstName'] ?></td>
            <td><?= $student_record['lastName'] ?></td>
        </tr>
    </table>
</div>
<hr>
<?php

$student_type = $student->getValue('uType');

if ($student_type == 'Admin') {
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            Cannot change other administrator password
        </div>
    </div>
    <?php
    exit;
}

$f = new Form();

$password_form_data = $f->showForm([
    'password1' => new PasswordField('Enter Password'),
    'password2' => new PasswordField('Re-enter Password'),
    'ID' => new HiddenField('ID', $student_id)
]);

if (isset($password_form_data['password1'])) {
    if ($password_form_data['password1'] != $password_form_data['password2']) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                Passwords do not match
            </div>
        </div>
        <?php
        exit;
    }
    try {
        $student->update([
            'pWord' => $password_form_data['password1']
        ]);
    } catch (Exception $e) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                Error: <?php echo $e->getMessage() ?>
            </div>
        </div>
        <?php
        exit;
    }
    ?>
    <div class="container">
        <div class="alert alert-success" role="alert">
            Password successfully updated
        </div>
    </div>
    <?php
}