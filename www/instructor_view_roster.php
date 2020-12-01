<?php
$roles = ['Instructor'];
$page_title = "Class Roster";
include_once 'header.php';

$term_form = new Form("get");
$course_form = new Form("get");

$class_list = new ClassList();
$terms = $class_list->getUnique('TermNumber', [
    'FacultyID' => $_SESSION["u_data"]["ID"]
]);

$term_field = new SelectField("Term", $terms);
$term_data = $term_form->showForm([
    'Term' => $term_field
]);

$course_data = $course_form->getValues([
    'Course',
    'Semester',
    'Year'
]);

if ($term_data || $course_data) {
    $term = $term_data['Term'];
    $year = substr($term, -4, 4);
    $semester = substr($term, 0, strlen($term) - 4);

    $section = new Section();
    $section_record = $section->get([
        'FacultyID' => $_SESSION["u_data"]["ID"],
        'Semester' => $semester,
        'Year' => $year
    ]);

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
    ]);
}

if (isset($course_data['Course'])) {
    $crn = substr($course_data['Course'], 0, 5);

    $grid = new Grid(new ClassList(), [
        ':r_1' => ['Last Name', 'Student', 'lastName'],
        ':r_2' => ['First Name', 'Student', 'firstName'],
        'FacultyID' => 'Faculty ID',
        'TermNumber' => 'Term',
        'CourseRegistrationNumber' => 'CRN'
    ]);

    $grid->showGrid([
        'TermNumber' => $term,
        'FacultyID' => $_SESSION["u_data"]["ID"],
        'CourseRegistrationNumber' => $crn
    ]);
}


?>

<?php include_once 'footer.php' ?>