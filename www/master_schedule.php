<?php
$roles = ['Student', 'Admin'];
$page_title = "Master Schedule";
include 'header.php';

$g = new Grid(new Section(), [
    "CourseRegistrationNumber" => "Course Registration Number",
    "SectionNumber" => "Section Number",
    'CourseID' => "CourseID",
    'SeatsCapacity' => "Seats",
    'RoomID' => "Room",
    'BuildingName' => "Building",
    ':r_01' => ['Dept. Code', 'Course', 'departmentcode'],
]);

$dept = new Department();

$i = 0;
$departmentNames = array();
for ($departments = $dept->get(); $departments; $departments = $dept->next()) {
    $departmentNames[] = $dept->getValue("DepartmentID");
}

$deptField = new SelectField("Department", $departmentNames);

$f = new Form();
$d = $f->showForm([
    "CourseRegistrationNumber" => "Course Registration Number",
    "SectionNumber" => "Section Number",
    ['CourseIDMin' => "Seats Min", 'CourseIDMax' => "Seats Max"],
    'RoomID' => "Room",
    'BuildingName' => "Building",
    'Department' => $deptField
]);

echo "<hr>";

if ($d != null) {
    $filter = array(
        "CourseRegistrationNumber" => $d['CourseRegistrationNumber'],
        "SectionNumber" => $d['SectionNumber'],
        "CourseID" => [$d['CourseIDMin'], $d['CourseIDMax']],
        "RoomID" => $d['RoomID'],
        "BuildingName" => $d['BuildingName'],
        ":r_01" => ['Course', 'departmentcode', ['a', 'b']]
    );

    $g->showGrid($filter);
}
?>

<?php include 'footer.php' ?>

