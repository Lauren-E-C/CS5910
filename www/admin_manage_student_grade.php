<?php
include_once 'admin_manage_student_header.php';

$f = new Form("get");

$d = $f->showForm([
    "crn_1" => "Course Registration Number",
    'Midterm_Grade' => 'Midterm Grade',
    'Final_Grade' => 'Final Grade',
    'ID' => new HiddenField('StudentID', $student_id)
]);

if (isset($d["crn_1"])) {
    echo "<div class=\"container\">\n";

    $midterm_grade = $d["Midterm_Grade"];
    $final_grade = $d["Final_Grade"];

    if ($d["crn_1"]) {
        change_grade($d["crn_1"], $student_id, $midterm_grade, $final_grade);
    }
    echo "</div>\n";
}

function change_grade($crn, $student_id, $midterm_grade, $final_grade)
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

    $r = [
        "CourseRegistrationNumber" => $crn,
        "StudentID" => $student_id
    ];

    $msg = "";

    if ($midterm_grade) {
        $old_midterm_grade = $enrollment->getValue('Midterm_Grade');
        $r['Midterm_Grade'] = $midterm_grade;
        $msg = "Midterm Grade changed";
        if ($old_midterm_grade) {
            $msg .= " from $midterm_grade";
        }
        $msg .= " to $midterm_grade<br>";
    }

    if ($final_grade) {
        $old_final_grade = $enrollment->getValue('Final_Grade');
        $r['Final_Grade'] = $final_grade;
        $msg .= "Final Grade changed";
        if ($old_final_grade) {
            $msg .= " from $old_final_grade";
        }
        $msg .= " to $final_grade<br>";
    }

    if ($midterm_grade || $final_grade) {
        try {
            $enrollment->update($r);
        } catch (Exception $e) {
            ?>
            echo
            <div class="alert alert-danger" role="alert">Error registering <?php echo $e->getMessage() ?></div>
            <?php
            return;
        }
    }
    if (!$msg) $msg = "Grade not updated";
    ?>
    <div class="alert alert-success" role="alert"><?= $msg ?></div>
    <?php
}