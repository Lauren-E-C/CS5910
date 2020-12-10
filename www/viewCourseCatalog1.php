<?php
$roles = ['Student', 'Admin', 'Instructor', 'Researcher'];
$page_title = "Course Catalog";
include_once 'header.php';

$catalog_form = new Form("get");

$course_list = new CourseCatalog();
$terms = $course_list->getUnique('TermNumber');

$course_field = new CourseField("Term", $terms);
$term_data = $term_form->showForm([
    'Term' => $term_field
]);

if ($term_data) {
    $term = $term_data['Term'];

    $class_list_grid = new Grid(new ClassList(), [
        ':r_01' => ['Course ID', 'Course', 'coursenumber'],
        ':r_02' => ['Department', 'Course', 'departmentcode'],
        ':r_03' => ['Course<br>Name', 'Course', 'coursename'],
        ':r_04' => ['Credits', 'Course', 'credits'],
        ':r_05' => ['Description', 'Course', 'coursedescription'],
        ':r_06' => ['Level', 'Course', 'level'],
        ':r_07' => ['Prerequisites', 'Course', 'prerequisites'],
    ]);

    $class_list_grid->showGrid([
        'TermNumber' => $term
    ]);

    //
    $class_term_list = new ClassList();
    //
    $class_list_record = $class_list->get([
        'StudentID' => $_SESSION["u_data"]["ID"]
    ]);


    ?>


    <?php
}
include_once 'footer.php';

