<?php
include_once 'admin_manage_student_header.php';

$f = new Form("get");

$d = $f->showForm([
    "crn_1" => "Course Registration Number",
    'ID' => new HiddenField('ID', $student_id)
]);

if (isset($d["crn_1"])) {
    echo "<div class=\"container\">\n";
    if ($d["crn_1"]) {
        class_drop($d["crn_1"], $student_id);
    }
    echo "</div>\n";
}

function class_drop($crn, $student_id)
{
    $section = new Section();
    $enrollment = new Enrollment();
    $class_list = new ClassList();

    $section_data = $section->get([
        'CourseRegistrationNumber' => $crn
    ]);

//    $course = $section->getRelatedModel('Course');
//    $course_id = $course->getValue('courseID');

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

    if (!$enrollment_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            Student is not registered for Course Registration Number $crn!
        </div>";
        return;
    }

    $class_list_data = $class_list->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $student_id
    ]);

    if (!$class_list_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            Student is not registered for Course Registration Number $crn!
        </div>";
        return;
    }

    try {
        $enrollment->delete([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $student_id
        ]);
        $class_list->delete([
            "CourseRegistrationNumber" => $crn,
            "StudentID" => $student_id
        ]);
        $section->update([
            'SeatsUsed'=> $section->getValue('SeatsUsed') - 1
        ]);
    } catch (Exception $e) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            Error dropping $crn : <?php echo $e->getMessage(); ?> 
        </div>";
        return;
    }

    echo "<div class=\"alert alert-success\" role=\"alert\">
            Course $crn dropped
        </div>";
}