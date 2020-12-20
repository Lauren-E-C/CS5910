<?php
$roles = ['Instructor'];
$page_title = "Schedule";
include_once 'header.php';

$term_form = new Form("get");

$class_list = new ClassList();
$terms = $class_list->getUnique('TermNumber', [
    'FacultyID' => $_SESSION["u_data"]["ID"]
]);

$term_field = new SelectField("Term", $terms);
$term_data = $term_form->showForm([
    'Term' => $term_field
]);

if ($term_data) {
    $term = $term_data['Term'];
    $year = substr($term, -4, 4);
    $semester = substr($term, 0, strlen($term) - 4);

    $grid = new Grid(new ClassList(), [
        'CourseRegistrationNumber' => 'CRN',
        ':r_01' => ['Instructor<br>First Name', 'Faculty', 'firstName'],
        ':r_02' => ['Instructor<br>Last Name', 'Faculty', 'lastName'],
        ':r_03' => ['Department', 'Course', 'departmentcode'],
        ':r_04' => ['Section Number', 'Section', 'SectionNumber'],
        ':r_05' => ['Course Number', 'Section', 'CourseID'],
        ':r_06' => ['Course Name', 'Course', 'coursename'],
        ':r_07' => ['Room', 'Section', 'RoomID'],
        ':r_08' => ['Days', 'TimeSlot', 'DaysOfWeek'],
        ':r_09' => ['Start Time', 'TimeSlot', 'StartTime'],
        ':r_10' => ['End Time', 'TimeSlot', 'EndTime'],
    ]);

    $grid->showGrid([
        'FacultyID' => $_SESSION["u_data"]["ID"],
        'TermNumber' => $term
    ]);
}

?>

<?php include_once 'footer.php' ?>