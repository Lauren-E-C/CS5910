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
        $form_major = new Form("get");
        $form_major_data = $form_major->showForm([
            'MajorName' => new SelectField('Major', $majors),
            'DeclaredDate' => new DateField('Declared Date'),
            'StudentID' => new HiddenField('StudentID', $student_id)
        ]);
        if (isset($form_major_data['MajorName'])) {
            $major_name = $form_major_data['MajorName'];
            $student_major = new StudentMajor();
            $major_record = $student_major->get([
                'StudentID' => $student_id
            ]);
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
        <?php
        // minor
        if ($major_name) {
            echo "<h1>Minor</h1>";

            $minor = new minor("get");

            $minors = array();
            for ($minor_record = $minor->get(); $minor_record; $minor_record = $minor->next()) {
                if ($major_name == $minor_record['MajorAffiliation']) {
                    $minors[] = $minor_record['MinorName'];
                }
            }

            if (count($minors)) {
                echo "<!--- Minor Form -->";
                $form_minor = new Form();
                $form_minor_data = $form_minor->showForm([
                    'MinorName' => new SelectField('Minor', $minors),
                    'DeclaredDate' => new DateField('Declared Date'),
                    'MajorName' => new HiddenField('MajorName', $major_name),
                    'StudentID' => new HiddenField('StudentID', $student_id)
                ]);

                if (isset($form_minor_data['MinorName'])) {
                    $minor_name = $form_minor_data['MinorName'];
                    $student_minor = new StudentMinor();
                    $minor_record = $student_minor->get([
                        'StudentID' => $student_id
                    ]);
                    if (!$minor_record) {
                        $student_minor->create([
                            'MinorName' => $form_minor_data['MinorName'],
                            'DeclaredDate' => $form_minor_data['DeclaredDate'],
                            'StudentID' => $form_minor_data['StudentID']
                        ]);
                    } else {
                        $student_minor->update([
                            'MinorName' => $form_minor_data['MinorName'],
                            'DeclaredDate' => $form_minor_data['DeclaredDate'],
                            'StudentID' => $form_minor_data['StudentID']
                        ]);
                    }
                }
            }
        }
        ?>
    </div>

<?php include_once 'footer.php' ?>