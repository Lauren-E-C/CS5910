<?php
$roles = ['Admin'];
$page_title = "Unlock User Account";
include_once 'header.php';

$grid = new Grid(new Users(), [
    'ID' => 'Id',
    'firstName' => 'First Name',
    'lastName' => 'Last Name',
    'uLocked' => 'Locked',
    'failedLogins' => 'Failed Logins'
]);

$grid->setOnclickPage('admin_unlock_form.php');

$grid->showGrid([
    'uLocked' => 'Yes'
]);

include_once 'footer.php'
?>