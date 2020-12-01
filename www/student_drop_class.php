<?php
$roles = ['Student'];
$page_title = "Drop Class";
include 'header.php';

$f = new Form();

$d = $f->showForm([
    "crn_1" => "Course Registration Number"
]);

if ($d) {
    echo "<div class=\"container\">\n";
    if ($d["crn_1"]) {
        drop_class($d["crn_1"]);
    }
    echo "</div>\n";
}

function drop_class($crn)
{
    $section = new Section();
    $enrollment = new Enrollment();
    $class_list = new ClassList();

    $section_data = $section->get([
        'CourseRegistrationNumber' => $crn
    ]);

    if (!$section_data) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            The Course Registration Number $crn does not exist!
        </div>";
        return;
    }

    $enrollment_data = $enrollment->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $_SESSION["u_data"]["ID"]
    ]);

    if (!$enrollment_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            You are not registered for Course Registration Number $crn!
        </div>";
        return;
    }

    $class_list_data = $class_list->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $_SESSION["u_data"]["ID"]
    ]);

    if (!$class_list_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            You are not registered for Course Registration Number $crn!
        </div>";
        return;
    }

    try {
        $enrollment->delete([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $_SESSION["u_data"]["ID"]
        ]);
        $class_list->delete([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $_SESSION["u_data"]["ID"]
        ]);
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            Error dropping $crn 
        </div>";
        return;
    }

    echo "<div class=\"alert alert-success\" role=\"alert\">
            Course $crn Dropped
        </div>";
}

include 'footer.php';


?>

