<?php
$roles = ['Instructor', 'Admin'];
$page_title = "Take Attendance";
include_once 'header.php';

$crn_form = new Form("get");
$student_form = new Form("get");

$student_form_data = $student_form->getValues([
    'Student',
    'Attendance',
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

    $attendance_field = new SelectField("Attendance", [
        'Present',
        'Absent'
    ]);

    $course_student_field = new SelectField('Student', $course_student_values);
    $course_course_field = new HiddenField('Course', $crn);
    $course_date_filed = new DateField("Date");
    $course_date_filed->setValue(date('Y-m-d'));

    $student_form_data = $student_form->showForm([
        'Student' => $course_student_field,
        'Attendance' => $attendance_field,
        'Date' => $course_date_filed,
        'Course' => $course_course_field
    ]);

    if (isset($student_form_data['Student'])) {
        $student_id = substr($student_form_data['Student'], 0, 6);
        $attendance = new Attendance();
        echo "<div class=\"container\">";
        try {
            $r = $attendance->get([
                'StudentID' => $student_id,
                'CourseRegistrationNumber' => $student_form_data['Course'],
                'Date' => $student_form_data['Date']
            ]);
            if ($r) {
                $attendance->update([
                    'Status' => $student_form_data['Attendance']
                ]);
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo "Attendance successfully updated.";
                echo "</div>";
            } else {
                $r = $attendance->create([
                    'StudentID' => $student_id,
                    'CourseRegistrationNumber' => $student_form_data['Course'],
                    'Date' => $student_form_data['Date'],
                    'Status' => $student_form_data['Attendance']
                ]);
                echo "<div class=\"alert alert-success\" role=\"alert\">";
                echo "Attendance successfully created.";
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