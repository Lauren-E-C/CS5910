<?php
$roles = ['Student'];
$page_title = "Class Registration";
include 'header.php';

$f = new Form();
?>

<h1><?= $page_title ?></h1>
<?php
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

    if ($enrollment_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            You are already registered for Course Registration Number $crn!
        </div>";
        return;
    }

    $class_list_data = $class_list->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $_SESSION["u_data"]["ID"]
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
            "StudentID" => $_SESSION["u_data"]["ID"],
            "EnrollmentDate" => date('Y-m-d H:i:s')
        ]);
        $class_list->create([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $_SESSION["u_data"]["ID"],
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

