<?php
$roles = null;
$page_title = "Course Catalog";
include_once 'header.php';


$department = new Department();  // create model to get access to the "Department" table

// gather all departments as an associative array
// store department id as key
// store department name as value
$department_values = array();

$department_record = $department->get();  // get first record
while ($department_record) {   // loop until no more data

    // get the data from the columns
    $department_id = $department->getValue('DepartmentID');
    $department_name = $department->getValue('DepartmentName');

    // store in associative array
    $department_values[$department_id] = $department_name;


    // get the next record from table if any
    $department_record = $department->next();
}

// create a select list field with the key/values from the department table
$department_field = new KeyValueField('Department', $department_values);

// create a form using the HTTP "get" method
$f = new Form("GET");

// display the form
$form_data = $f->showForm([
    'DepartmentID' => $department_field // show $department_field in one bootstrap row
]);


// if the user submitted the form, then do something with the submitted data
if ($form_data) {
    $department_id = $form_data['DepartmentID']; // get the user submitted department id

    // create a grid for the Course model that shows the course name
    $g = new Grid(new Course(), [
        'departmentcode' =>  'Department Code',
        'coursenumber' =>  'Course Number',
        'coursename' =>  'Course Name',
        'description' =>  'Description',
        'level' =>  'Level',
        'prerequisites' =>  'Prerequisites',
        'credits' =>  'Credits'
    ]);

    // add url to go to if the user clicks a row
    //$g->setOnclickPage('view_course_catalog_detail.php');

    // show the grid, filter course items by departmentcode
    $g->showGrid([
        'departmentcode' => $department_id
    ]);

} else {
    echo "Form not submitted";
}

?>