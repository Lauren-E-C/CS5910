<?php

session_start();
$_SESSION["s"] = session_id();

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
            'View/Manage Advised Students' => '#',
        ],
        'Course Management' => [
            'View Class Roster' => 'instructor_view_roster.php',
            'Take Attendance' => '#',
            'Assign Midterm Grades' => 'instructor_assign_grade.php',
            'Assign Final Grades' => '#',
        ]
    ],
    'Admin' => [
        'Course Catalog Management' => [
            'View Course Catalog' => 'welcomePageOptions/viewCourseCatalog.php',
            'Search Course Catalog' => '#',
            'Add To Course Catalog' => '#',
            'Edit Course Catalog' => '#',
            'Delist Course In Catalog' => '#',
            'Relist Course In Catalog' => '#',
        ],
        'Prerequisite Management' => [
            'Prerequisite Table' => '#',
            'Add Prerequisite To Course' => '#',
            'Remove Prerequisite From Course' => '#',

        ],
        'Department Management' => [
            'Department List' => '#',
            'Create Department' => '#',
            'Edit Department' => '#',

        ],
        'Semester Management' => [
            'View Master Schedule' => 'welcomePageOptions/searchMasterSchedule.php',
            'Search For A Class' => 'master_schedule.php',
            'Add Course Section' => '#',
            'Edit Course Section' => '#',
            'Remove Course Section' => '#',
        ],
        'Account Management' => [
            'Manage Admin Account' => '#',
            'Manage Student Account' => '#',
            'Manage Faculty Account' => '#',
            'Manage Researcher Account' => '#',
            'Create Hold' => '#',

        ],
        'Calander Management' => [
            'View Academic Calander' => 'academicCalander.php',
            'Add to Academic Calander' => '#',
            'Edit Academic Calander' => '#',

        ],
    ],
    'Researcher' => [
        'Available Data' => [
            'Popular Majors' => '#',
            'Evening Courses' => '#',
            'Lab Courses' => '#',
            'Computer Science Courses' => '#',
        ],
        'Courses And Sections' => [
            'Prerequisite Table' => '#',
            'Search Master Schedule' => '#',
            'Search Course Catalog' => '#',
            'Course Catalog' => 'welcomePageOptions/viewCourseCatalog.php'

        ],
    ],
    'Student' => [
        'Student Records' => [
            'Class Registration' => 'student_register.php',
            'Prerequisites' => '#',
            'Drop Class' => 'student_drop_class.php',
            'View Course Catalog' => 'welcomePageOptions/viewCourseCatalog.php',
            'Search For A Class' => 'master_schedule.php',

        ],
        'Registration' => [
            'Schedule' => 'student_schedule.php',
            'Holds' => '#',
            'Degree Audit' => '#',
            'Unofficial Transcript' => '#',
            'Search For A Class' => '#',
        ],
        'Advising' => [
            'Academic Advisor' => '#'
        ]
    ],

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
require_once $base_dir . '/models/ClassList.php';
require_once $base_dir . '/models/Enrollment.php';
require_once $base_dir . '/models/Course.php';
require_once $base_dir . '/models/TimeSlot.php';
require_once $base_dir . '/models/Building.php';
require_once $base_dir . '/models/Section.php';
require_once $base_dir . '/models/Room.php';
require_once $base_dir . '/models/Department.php';
require_once $base_dir . '/utils/Grid.php';
require_once $base_dir . '/utils/Form.php';