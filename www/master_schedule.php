<?php
$roles = ['Student', 'Admin', 'Researcher'];
$page_title = "Master Schedule";
include 'header.php';

$g = new Grid(new SectionCourse(), [
    "CourseRegistrationNumber" => "Course Registration Number",
    "SectionNumber" => "Section Number",
    'CourseID' => "CourseID",
    'SeatsCapacity' => "Seats",
    'RoomID' => "Room",
    'BuildingName' => "Building",
    'departmentcode' => 'Department',
    'Semester' => 'Semester',
    'Year' => 'Year',
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
    ['SeatsMin' => "Seats Min", 'SeatsMax' => "Seats Max"],
    'RoomID' => "Room",
    'BuildingName' => "Building",
    'Department' => $deptField,
    'Semester' => "Semester",
    'Year' => "Year",
]);

echo "<hr>";

if ($d != null) {
    $filter = array();

    if ($d['CourseRegistrationNumber']) {
        $filter["CourseRegistrationNumber"] = $d['CourseRegistrationNumber'];
    }

    if ($d['SectionNumber']) {
        $filter["SectionNumber"] = $d['SectionNumber'];
    }

    if ([$d['SeatsMin'] || $d['SeatsMax']]) {
        $filter["SeatsCapacity"] = [$d['SeatsMin'], $d['SeatsMax']];
    }

    if ($d['RoomID']) {
        $filter["RoomID"] = $d['RoomID'];
    }

    if ($d['BuildingName']) {
        $filter["BuildingName"] = $d['BuildingName'];
    }

    if ($d['Department']) {
        $filter["departmentcode"] = $d['Department'];
    }

    if ($d['Semester']) {
        $filter["Semester"] = $d['Semester'];
    }
    if ($d['Year']) {
        $filter["Year"] = $d['Year'];
    }

    $g->showGrid($filter);
}
?>

<?php include 'footer.php' ?>

