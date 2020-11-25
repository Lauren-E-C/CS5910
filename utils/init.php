<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user_pages = [
    'Student' => 'welcomeStudent.php',
    'Instructor' => 'welcomeFaculty.php',
    'Researcher' => 'welcomeResearcher.php',
    'Admin' => 'welcomeAdmin.php'
];

$user_nav = [
    'Instructor' => [
        'Advisor Management' => [
            'View/Manage Advised Students' => '#'
        ],
        'Course Management' => [
            'View Class Roster' => '#',
            'Take Attendance' => '#',
            'Assign Midterm Grades' => '#',
            'Assign Final Grades' => '#'
        ]
    ],
    'Admin' => [
        'Course Catalog Management' => [
            'View Undergraduate Catalog' => '#',
            'Search Course Catalog' => '#',
        ],
        'Prerequisite Management' => [
            'Prerequisite Table' => '#'
        ]
    ],
    'Student' => [
        'xxx' => [
            'yyy' => '#'
        ]
    ]
];

if ($_SERVER['SCRIPT_URL'] != "/www/login.php" && $_SERVER['SCRIPT_URL'] != "/www/denied.php") {
    if (!isset($roles)) {
        $roles = [];
    }

    if (!isset($_SESSION["u_type"])) {
        header("Location: login.php");
        exit;
    } else {
        if (!in_array($_SESSION["u_type"], $roles)) {
            header("Location: denied.php");
            exit;
        }
    }
}

$base_dir = ".";

if (isset($_SERVER['DOCUMENT_ROOT'])) {
    $base_dir = $_SERVER['DOCUMENT_ROOT'];
}

require_once $base_dir . '/utils/Database.php';
require_once $base_dir . '/utils/ModelInterface.php';
require_once $base_dir . '/utils/Model.php';
require_once $base_dir . '/models/Users.php';
require_once $base_dir . '/models/Faculty.php';
require_once $base_dir . '/models/Course.php';
require_once $base_dir . '/models/TimeSlot.php';
require_once $base_dir . '/models/Building.php';
require_once $base_dir . '/models/Section.php';
require_once $base_dir . '/models/Room.php';
require_once $base_dir . '/models/Department.php';
require_once $base_dir . '/utils/Grid.php';
require_once $base_dir . '/utils/Form.php';