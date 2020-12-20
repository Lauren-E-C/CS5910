<?php
$roles = ['Student'];
include_once 'header.php';

$student_holds = new StudentHolds();
$student_holds_record = $student_holds->get([
    'StudentID' => $_SESSION["u_data"]["ID"]
]);

$hold_name = "";

echo "<div class=\"container\">";
if (!$student_holds_record) {
    ?>
    <div class="alert alert-success" role="alert">
        Account not on hold.
    </div>
    <?php
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

echo "</div>";
include_once 'footer.php';