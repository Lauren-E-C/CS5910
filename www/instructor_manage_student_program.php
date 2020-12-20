<?php
$roles = ['Instructor'];
$page_title = "Manage Student";
include_once 'header.php';

$major_name = null;

// Major
$major = new Major();

$majors = array();
for ($major_record = $major->get(); $major_record; $major_record = $major->next()) {
    $majors[] = $major_record['MajorName'];
}

$minor = new Minor();
$minors = array(
    "Minor not declared"
);

for ($minor_record = $minor->get(); $minor_record; $minor_record = $minor->next()) {
    $minors[] = $minor_record['MinorName'];
}

$student_id = null;

if (isset($_GET['StudentID'])) {
    $student_id = $_GET['StudentID'];
} else {
    $student_id = $_POST['StudentID'];
}

$student = new Users();
$student_record = $student->get([
    'ID' => $student_id
]);

// $_SERVER['SCRIPT_URL']
$manage_links = array(
    'instructor_manage_student_schedule.php' => 'Class Schedule',
    'instructor_manage_student_viewhold.php' => 'View Hold',
    'instructor_manage_student_transcript.php' => 'Unofficial Transcript',
    'instructor_manage_student_audit.php' => 'Degree Audit',
    'instructor_manage_student_program.php' => 'Student Program',
);

?>
    <div class="d-flex justify-content-center">
        <?php foreach ($manage_links as $href => $text) {
            $selected = "btn btn-outline-primary";
            if ("/www/" . $href == $_SERVER['SCRIPT_URL']) {
                $selected = "btn-primary";
            } ?>
            <a href="<?= $href ?>?StudentID=<?= $student_id ?>" class="btn <?= $selected ?> my-2 my-sm-0"
               style="margin: 2px;"><?= $text ?></a>
        <?php } ?>
    </div>
    <div class="container">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
            <tr>
                <td><?= $student_record['ID'] ?></td>
                <td><?= $student_record['firstName'] ?></td>
                <td><?= $student_record['lastName'] ?></td>
            </tr>
        </table>
    </div>
    <div class="container">
        <hr>
        <h1>Major</h1>
        <?php
        $form_major = new Form();

        $student_major = new StudentMajor();
        $major_record = $student_major->get([
            'StudentID' => $student_id
        ]);

        if ($major_record) {

            $phpdate = strtotime($major_record['DeclaredDate']);
            $mysqldate = date('Y-m-d', $phpdate);

            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                $major_name = $major_record['MajorName'];
                $form_major->setValues([
                    'DeclaredDate' => $mysqldate,
                    'MajorName' => $major_record['MajorName']
                ]);
            }
        }

        $form_major_data = $form_major->showForm([
            'MajorName' => new SelectField('Major', $majors),
            'DeclaredDate' => new DateField('Declared Date'),
            'StudentID' => new HiddenField('StudentID', $student_id)
        ]);

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['MajorName'])) {
            $major_name = $form_major_data['MajorName'];
            if (!$major_record) {
                $student_major->create(
                    $form_major_data
                );
            } else {
                $student_major->update(
                    $form_major_data
                );
            }
        }
        ?>
        <hr>
        <h1>Minor</h1>
        <?php
        $form_minor = new Form();

        $student_minor = new StudentMinor();
        $minor_record = $student_minor->get([
            'StudentID' => $student_id
        ]);

        if ($minor_record) {

            $phpdate = strtotime($minor_record['DeclaredDate']);
            $mysqldate = date('Y-m-d', $phpdate);

            if ($_SERVER['REQUEST_METHOD'] != "POST") {
                $minor_name = $minor_record['MinorName'];
                $form_minor->setValues([
                    'DeclaredDate' => $mysqldate,
                    'MinorName' => $minor_record['MinorName']
                ]);
            }
        }

        $form_minor_data = $form_minor->showForm([
            'MajorName' => new HiddenField('Major', $major_name),
            'MinorName' => new SelectField('Minor', $minors),
            'DeclaredDate' => new DateField('Declared Date'),
            'StudentID' => new HiddenField('StudentID', $student_id)
        ]);

        unset($form_minor_data['MajorName']);

        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['MinorName']) && $_POST['MinorName'] != 'Minor not declared') {
            $minor_name = $form_minor_data['MinorName'];
            if (!$minor_record) {
                $student_minor->create(
                    $form_minor_data
                );
            } else {
                $student_minor->update(
                    $form_minor_data
                );
            }
        }

        ?>
    </div>

<?php include_once 'footer.php' ?>