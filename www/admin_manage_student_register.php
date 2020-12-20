<?php
include_once 'admin_manage_student_header.php';

$f = new Form("get");

$d = $f->showForm([
    "crn_1" => "Course Registration Number",
    'ID' => new HiddenField('StudentID', $student_id)
]);

if (isset($d["crn_1"])) {
    echo "<div class=\"container\">\n";
    if ($d["crn_1"]) {
        class_register($d["crn_1"], $student_id);
    }
    echo "</div>\n";
}

function class_register($crn, $student_id)
{
    $section = new Section();
    $enrollment = new Enrollment();
    $class_list = new ClassList();

    $section_data = $section->get([
        'CourseRegistrationNumber' => $crn
    ]);

//    $course = $section->getRelatedModel('Course');
//    $course_id = $course->getValue('courseID');

    if (!$section_data) { ?>
        <div class="alert alert-danger" role="alert">
            The Course Registration Number <?= $crn ?> does not exist!
        </div>
        <?php
        return;
    }

    if ($section->getValue('SeatsUsed') >= $section->getValue('SeatsCapacity')) { ?>
        <div class="alert alert-danger" role="alert">
            The Course has reached capacity.
        </div>
        <?php
        return;
    }

//    $current_term = new CurrentTerm();
//    $current_term_record = $current_term->get([
//        'ID' => 1
//    ]);
//
//    if ($section->getValue('Semester') != $current_term->getValue('Semester')) { ?>
<!--        <div class="alert alert-danger" role="alert">-->
<!--            Section not in current semester.-->
<!--        </div>-->
<!--        --><?php
//        return;
//    }
//
//    if ($section->getValue('Year') != $current_term->getValue('Year')) { ?>
<!--        <div class="alert alert-danger" role="alert">-->
<!--            Section not in current school year.-->
<!--        </div>-->
<!--        --><?php
//        return;
//    }

    $enrollment_data = $enrollment->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $student_id
    ]);

    if ($enrollment_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            Student is already registered for Course Registration Number $crn!
        </div>";
        return;
    }

    $class_list_data = $class_list->get([
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $student_id
    ]);

    if ($class_list_data) {
        echo "<div class=\"alert alert-warning\" role=\"alert\">
            Student is already registered for Course Registration Number $crn!
        </div>";
        return;
    }


    // ,
    //            "Midterm_Grade" => null,
    //            "Final_Grade" => null,

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
        $section->update([
            'SeatsUsed'=> $section->getValue('SeatsUsed') + 1
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