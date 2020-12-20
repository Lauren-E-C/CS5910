<?php
$roles = ['Admin'];
$page_title = "Faculty Maintenance";
include_once 'header.php';
?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin: 10px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <nav class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a href="admin_faculty_add.php" class="btn btn-success my-2 my-sm-0">Add Faculty</a>
                </li>
            </ul>
        </nav>
    </nav>
    <?php
    $g = new Grid(new Users(), [
        'ID' => 'Faculty<br>ID',
        'firstName' => 'First<br>Name',
        'lastName' => 'Last<br>Name',
    ]);
    $g->setOnclickPage('admin_faculty_edit.php');
    $g->setButtons([
            'Manage' => 'admin_manage_faculty_roster.php'
    ]);
    $g->showGrid([
        'uType' => 'Instructor'
    ]);
    ?>

</div>
