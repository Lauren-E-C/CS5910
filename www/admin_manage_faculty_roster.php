<?php
include_once 'admin_manage_faculty_header.php';

$term_form = new Form("get");
$course_form = new Form("get");

$class_list = new ClassList();
$terms = $class_list->getUnique('TermNumber', [
    'FacultyID' => $student_id
]);

$term_field = new SelectField("Term", $terms);
$term_data = $term_form->showForm([
    'Term' => $term_field,
    'ID' => new HiddenField('ID', $student_id)
]);

$course_data = $course_form->getValues([
    'Course',
    'Semester',
    'Year'
]);

if (isset($_GET['Term']) || $course_data) {
    $term = $term_data['Term'];
    $year = substr($term, -4, 4);
    $semester = substr($term, 0, strlen($term) - 4);

    $section = new Section();
    $section_record = $section->get([
        'FacultyID' => $student_id,
        'Semester' => $semester,
        'Year' => $year
    ]);

//    $r = [
//        'FacultyID' => $student_id,
//        'Semester' => $semester,
//        'Year' => $year
//    ];
//    echo "<pre>";
//    print_r($r);
//    echo "</pre>";

    $course_list = array();
    while ($section_record) {
        $course_list[] = $section->getValue('CourseRegistrationNumber') . ' - ' . $section->getValue('coursename', 'Course');
        $section_record = $section->next();
    }

    $course_field = new SelectField("Course", $course_list);
    $course_term = new HiddenField("Term", $term);
    $course_semester = new HiddenField("Semester", $semester);
    $course_year = new HiddenField("Year", $year);
    $course_data = $course_form->showForm([
        'Course' => $course_field,
        'Semester' => $course_semester,
        'Year' => $course_year,
        'Term' => $course_term,
        'ID' => new HiddenField("ID", $student_id)
    ]);
}

if (isset($course_data['Course'])) {
    $crn = substr($course_data['Course'], 0, 5);

    $grid = new Grid(new ClassList(), [
        'StudentID' => 'Student ID',
        ':r_1' => ['Last Name', 'Student', 'lastName'],
        ':r_2' => ['First Name', 'Student', 'firstName'],
        ':r_3' => ['Midterm Grade', 'Enrollment', 'Midterm_Grade'],
        ':r_4' => ['Final Grade', 'Enrollment', 'Final_Grade'],

        //'FacultyID' => 'Faculty ID',
        'TermNumber' => 'Term',
        //'CourseRegistrationNumber' => 'CRN'
    ]);

    $grid->showGrid([
        'TermNumber' => $term,
        'FacultyID' => $student_id,
        'CourseRegistrationNumber' => $crn
    ]);
}


?>

<?php include_once 'footer.php' ?>
