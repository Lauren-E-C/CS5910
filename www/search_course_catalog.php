<?php
$roles = null;
$page_title = "Course Catalog";
include_once 'header.php';


$department = new Department();  // create model to get access to the "Department" table
$department_values = $department->getKeyValues('DepartmentID', 'DepartmentName');

$course = new Course();
$course_values = $course->getKeyValues('courseID', 'coursename');

// create a select list field with the key/values from the department table
$department_field = new KeyValueField('Department', $department_values);
$course_field = new KeyValueField('Course', $course_values);

// create a form using the HTTP "get" method
$f = new Form("GET");

// display the form
$form_data = $f->showForm([
    'DepartmentID' => $department_field, // show $department_field in one bootstrap row
    'CourseID' => $course_field
]);


// if the user submitted the form, then do something with the submitted data
if ($form_data) {
    $department_id = $form_data['DepartmentID']; // get the user submitted department id
    $course_id = $form_data['CourseID']; // get the user submitted department id

    // create a grid for the Course model that shows the course name
    $g = new Grid(new Course(), [
        'departmentcode' => 'Department Code',
        'coursenumber' => 'Course Number',
        'coursename' => 'Course Name',
        'description' => 'Description',
        'level' => 'Level',
        'prerequisites' => 'Prerequisites',
        'credits' => 'Credits'
    ]);

    // add url to go to if the user clicks a row
    //$g->setOnclickPage('view_course_catalog_detail.php');

    // show the grid, filter course items by departmentcode
    $g->showGrid([
        'departmentcode' => $department_id,
        'courseID' => $course_id,
        'listed' => 'Y'
    ]);

} else {
    echo "Form not submitted";
}

?>