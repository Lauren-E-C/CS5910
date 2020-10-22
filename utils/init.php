<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'].'/utils/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utils/ModelInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utils/Model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/SystemUsers.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/models/Course.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utils/Grid.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/utils/Form.php';