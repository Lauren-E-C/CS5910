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
            'View/Manage Advised Students' => 'instructor_manage_student_grid.php',
        ],
        'Course Management' => [
            'View Class Roster' => 'instructor_view_roster.php',
            'Take Attendance' => 'instructor_take_attendance.php',
            'View Attendance' => 'instructor_view_attendance.php',
            'Assign Midterm Grades' => 'instructor_assign_midterm.php',
            'Assign Final Grades' => 'instructor_assign_final.php',
        ]
    ],
    'Admin' => [
        'Course Catalog Management' => [
            'View Course Catalog' => 'view_course_catalog.php',
            'Search Course Catalog' => 'search_course_catalog.php',
            'Course Catalog Maintenance' => 'admin_course_grid.php',
            'Prerequisite Table' => 'prerequisite_table.php',

        ],
        //'Prerequisite Management' => [

        //    'Add Prerequisite To Course' => '#',
        //    'Remove Prerequisite From Course' => '#',

        //],
        'Department Management' => [
            'Department List' => 'admin_department_grid.php',
            'Manage Major' => 'admin_major_grid.php',
            'Manage Minor' => 'admin_minor_grid.php',

        ],
        'Semester Management' => [
            'View Master Schedule' => 'view_master_schedule.php',
            'Search For A Class' => 'master_schedule.php',
            'Course Section Maintenance' => 'admin_section_grid.php',
            'Set Registration Term' => 'admin_current_term.php',

        ],
        'Account Management' => [
            'Manage Student Account' => 'admin_manage_student_grid.php',
            'Manage Faculty Account' => 'admin_faculty_grid.php',
            'Manage Researcher Account' => 'admin_manage_researcher_grid.php',
            'Unlock User Account' => 'admin_unlock_account.php',


        ],
        'Calendar Management' => [
            'View Academic Calendar' => 'admin_calendar_grid.php',
            'Add Event' => 'admin_calendar_add.php',

        ],
    ],
    'Researcher' => [
        'Available Data' => [
            'Popular Majors' => 'popular_majors.php',
            'Evening Courses' => 'evening_courses.php',
            'Lab Courses' => 'lab_courses.php',
            'Computer Science Courses' => 'compsci_courses.php',
        ],
        'Courses And Sections' => [
            'Prerequisite Table' => 'prerequisite_table.php',
            'Search Master Schedule' => 'master_schedule.php',
            'Search Course Catalog' => 'search_course_catalog.php',
            'View Course Catalog' => 'view_course_catalog.php'

        ],
    ],
    'Student' => [
        'Registration' => [
            'Class Registration' => 'student_register.php',
            'Prerequisites' => 'prerequisite_table.php',
            'Drop Class' => 'student_drop_class.php',
            'View Course Catalog' => 'view_course_catalog.php',
            'Search For A Class' => 'master_schedule.php',

        ],
        'Student Records' => [
            'Schedule' => 'student_schedule.php',
            'Holds' => 'student_viewhold.php',
            'Degree Audit' => 'student_degree_audit.php',
            'Unofficial Transcript' => 'student_transcript.php'
        ],
        'Advising' => [
            'Academic Advisor' => 'student_advisor.php'
        ]
    ],

];

if (!isset($roles)) {
    $roles = null;
}

if ($roles !== null && $_SERVER['SCRIPT_URL'] != "/www/login.php" && $_SERVER['SCRIPT_URL'] != "/www/denied.php") {
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
require_once $base_dir . '/utils/Grid.php';
require_once $base_dir . '/utils/Form.php';

require_once $base_dir . '/models/AcademicCalendar.php';
require_once $base_dir . '/models/Users.php';
require_once $base_dir . '/models/Faculty.php';
require_once $base_dir . '/models/ClassList.php';
require_once $base_dir . '/models/Enrollment.php';
require_once $base_dir . '/models/Course.php';
require_once $base_dir . '/models/Advisor.php';
require_once $base_dir . '/models/Holds.php';
require_once $base_dir . '/models/Major.php';
require_once $base_dir . '/models/MajorCount.php';
require_once $base_dir . '/models/StudentMajor.php';
require_once $base_dir . '/models/StudentHoldView.php';
require_once $base_dir . '/models/MajorRequirements.php';
require_once $base_dir . '/models/Minor.php';
require_once $base_dir . '/models/StudentMinor.php';
require_once $base_dir . '/models/CompSciMajor.php';
require_once $base_dir . '/models/MinorRequirements.php';
require_once $base_dir . '/models/Department.php';
require_once $base_dir . '/models/Prerequisites.php';
require_once $base_dir . '/models/StudentHolds.php';
require_once $base_dir . '/models/Attendance.php';
require_once $base_dir . '/models/TimeSlot.php';
require_once $base_dir . '/models/Building.php';
require_once $base_dir . '/models/Section.php';
require_once $base_dir . '/models/NightSection.php';
require_once $base_dir . '/models/SectionCourse.php';
require_once $base_dir . '/models/Room.php';
require_once $base_dir . '/models/Department.php';
require_once $base_dir . '/models/LabCourses.php';
require_once $base_dir . '/models/CurrentTerm.php';
require_once $base_dir . '/models/Researchers.php';