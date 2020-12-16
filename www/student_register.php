<?php
$roles = ['Student'];
$page_title = "Class Registration";
include 'header.php';

$student_hold = new StudentHolds();
if ($student_hold->get([
    'StudentID' => $_SESSION["u_data"]["ID"]
])) {
    $hold_desc = $student_hold->getValue('DescriptionOfHold', 'Holds');
    ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            Account on hold: <?= $hold_desc ?>
        </div>
    </div>
    <?php
    return;
}

$f = new Form();

$d = $f->showForm([
    "crn_1" => "Course Registration Number",
    "crn_2" => "Course Registration Number",
    "crn_3" => "Course Registration Number",
    "crn_4" => "Course Registration Number",
    "crn_5" => "Course Registration Number",
]);

if ($d) {
    echo "<div class=\"container\">\n";
    if ($d["crn_1"]) {
        class_register($d["crn_1"]);
    }
    if ($d["crn_2"]) {
        class_register($d["crn_2"]);
    }
    if ($d["crn_3"]) {
        class_register($d["crn_3"]);
    }
    if ($d["crn_4"]) {
        class_register($d["crn_4"]);
    }
    if ($d["crn_5"]) {
        class_register($d["crn_5"]);
    }
    echo "</div>\n";
}

function class_register($crn)
{
    $section = new Section();
    $enrollment = new Enrollment();
    $class_list = new ClassList();

    $student_id = $_SESSION["u_data"]["ID"];

    $section_data = $section->get([
        'CourseRegistrationNumber' => $crn
    ]);

    $course = $section->getRelatedModel('Course');
    $course_id = $course->getValue('courseID');

    $prerequisites = new Prerequisites();
    $prerequisites_record = $prerequisites->get([
        'CourseID' => $course_id
    ]);

    $preq_message = null;

    if ($prerequisites_record) {
        $preq_message = "Prerequsite course not taken";
        $enrollment = new Enrollment();
        $enrollment_data = $enrollment->get([
            'StudentID' => $student_id
        ]);
        while ($enrollment_data) {
            $enrolled_course_id = $enrollment->getValue('courseID', 'Course');
            if ($enrolled_course_id == $prerequisites->getValue('PreqCourseID')) {
                $preq_message = "You're too stupid to take this class";
                if ($enrollment->computeQuality($enrollment->getValue('Final_Grade')) >= 2) {
                    $preq_message = null;
                }
                break;
            }
            $enrollment_data = $enrollment->next();
        }
    }

    if ($preq_message) {
        ?>
        <div class="container">
            <div class="alert alert-danger" role="alert">
                Prerequsite requirement not met: <?= $preq_message ?>
            </div>
        </div>
        <?php
        return;
    }


    if (!$section_data) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            The Course Registration Number $crn does not exist!
        </div>";
        return;
    }

    $enrollment_data = $enrollment->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $student_id
    ]);

    if ($enrollment_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            You are already registered for Course Registration Number $crn!
        </div>";
        return;
    }

    $class_list_data = $class_list->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $student_id
    ]);

    if ($class_list_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            You are already registered for Course Registration Number $crn!
        </div>";
        return;
    }

    try {
        $enrollment->create([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $student_id,
            "EnrollmentDate" => date('Y-m-d H:i:s')
        ]);
        $class_list->create([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $student_id,
            "FacultyID" => $section_data["FacultyID"],
            "TermNumber" => $section_data["Semester"] . $section_data["Year"]
        ]);
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            Error registering $crn 
        </div>";
        return;
    }

    echo "<div class=\"alert alert-success\" role=\"alert\">
            Course $crn Registered
        </div>";
}

include 'footer.php';
?>

