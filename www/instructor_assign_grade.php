<?php
$roles = ['Instructor'];
$page_title = "Assign Grade";
include_once 'header.php';

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

$crn_form = new Form("get");
$course_student_field = new SelectField('Course', $course_crn_values);
$crn_form_data = $crn_form->showForm([
    'Course' => $course_student_field
]);

if ($crn_form_data) {
    $crn = substr($crn_form_data['Course'],0, 5);
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

    $student_form = new Form("get");
    $course_student_field = new SelectField('Student', $course_student_values);
    $course_course_field = new HiddenField('Course', $crn);

    $student_form_data = $student_form->showForm([
        'Student' => $course_student_field,
        'Grade' => "Grade",
        'CRN' => $course_course_field
    ]);

    if ($student_form_data) {
        print_r($student_form_data);
        die;
    }

}

include_once 'footer.php';