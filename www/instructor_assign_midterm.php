<?php
$roles = ['Instructor', 'Admin'];
$page_title = "Assign Midterm Grade";
include_once 'header.php';

$current_term = new CurrentTerm();
$current_term_record = $current_term->get([
    'ID' => 1
]);

if ($current_term->getValue('Exam') != 'Midterm') { ?>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            Time to grade midterms exam has expired.
        </div>
    </div>
    <?php
    exit;
}

$crn_form = new Form("get");
$student_form = new Form("get");

$student_form_data = $student_form->getValues([
    'Student',
    'Grade',
    'Course'
]);

$class_list = new ClassList();

$course_crn_record = $class_list->get([
    'FacultyID' => $_SESSION["u_data"]["ID"]
]);

$course_crn_values = array();
while ($course_crn_record) {
    if (!isset($course_crn_values[$class_list->getValue('CourseRegistrationNumber')])) {
        $course_crn_values[$class_list->getValue('CourseRegistrationNumber')] = $class_list->getValue('CourseRegistrationNumber') . ' - ' . $class_list->getValue('coursename', 'Course');
    }
    $course_crn_record = $class_list->next();
}


$course_student_field = new SelectField('Course', $course_crn_values);
$crn_form_data = $crn_form->showForm([
    'Course' => $course_student_field
]);

if ($crn_form_data || $student_form_data) {
    $crn = substr($crn_form_data['Course'], 0, 5);
    $class_student_record = $class_list->get([
        'FacultyID' => $_SESSION["u_data"]["ID"],
        'CourseRegistrationNumber' => $crn
    ]);

    $course_student_values = array();
    while ($class_student_record) {
        if (!isset($course_student_values[$class_list->getValue('CourseRegistrationNumber')])) {
            $course_student_values[$class_list->getValue('CourseRegistrationNumber')] = $class_list->getValue('StudentID') . ' - ' . $class_list->getValue('firstName', 'Student') . " " . $class_list->getValue('lastName', 'Student');
        }
        $class_student_record = $class_list->next();
    }

    $course_student_field = new SelectField('Student', $course_student_values);
    $course_course_field = new HiddenField('Course', $crn);

    $enrollment = new Enrollment();
    $grade_field = new SelectField("Grade", $enrollment->getGrades());

    $student_form_data = $student_form->showForm([
        'Student' => $course_student_field,
        'Grade' => $grade_field,
        'Course' => $course_course_field
    ]);

    if (isset($student_form_data['Student'])) {
        $student_id = substr($student_form_data['Student'], 0, 6);
        echo "<div class=\"container\">";
        try {
            $r = $enrollment->get([
                'StudentID' => $student_id,
                'CourseRegistrationNumber' => $student_form_data['Course']
            ]);
            if ($r) {
                $enrollment->update([
                    'Midterm_Grade' => $student_form_data['Grade']
                ]);
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo "Grade successfully assigned.";
                echo "</div>";
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">";
                echo "No enrollment for student: $student_id crn: {$student_form_data['Course']}";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">";
            echo $e->getMessage();
            echo "</div>";
        }
        echo "</div>";
    }

}

include_once 'footer.php';