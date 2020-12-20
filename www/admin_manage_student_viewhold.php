<?php
include_once 'admin_manage_student_header.php';

$student_holds = new StudentHolds();
$student_holds_record = $student_holds->get([
    'StudentID' => $student_id
]);

$hold_name = "";

echo "<div class=\"container\">";
if (!$student_holds_record) {
    ;
} else {
    $hold_name = $student_holds->getValue('HoldName');
    ?>
    <table class="table">
        <tr>
            <th>Hold Name</th>
            <th>Hold Type</th>
            <th>Hold Description</th>
        </tr>
        <tr>
            <td><?= $student_holds_record['HoldName'] ?></td>
            <td><?= $student_holds->getValue('TypeOfHold', 'Holds') ?></td>
            <td><?= $student_holds->getValue('DescriptionOfHold', 'Holds') ?></td>
        </tr>
    </table>
    <?php
}

$holds = new Holds();
$holds_select[""] = "Not on hold";
$holds_array = $holds->getKeyValues('HoldName', 'HoldName');
foreach ($holds_array as $k => $v) {
    $holds_select[$k] = $v;
}

if (isset($_GET['Hold'])) {
    $hold_name = $_GET['Hold'];
    $student_holds->delete([
        'StudentID' => $student_id
    ]);
    if (!$hold_name) {
        ?>
        <div class="alert alert-success" role="alert">Hold removed</div>
        <?php
    } else {
        $student_holds->create([
            'StudentID' => $student_id,
            'HoldName' => $hold_name
        ]);
        ?>
        <div class="alert alert-success" role="alert">Student placed on hold: <?= $hold_name ?></div>
        <?php
    }
}


$f = new Form("get");

$f->setValues([
    'Hold' => $hold_name,
]);

$f->showForm([
    'Hold' => new KeyValueField('Hold', $holds_select),
    'ID' => new HiddenField('ID', $student_id)
]);

echo "</div>";
include_once 'footer.php';

