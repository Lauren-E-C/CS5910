<?php
include_once 'instructor_manage_student_header.php';

$student_holds = new StudentHolds();
$student_holds_record = $student_holds->get([
    'StudentID' => $student_id
]);

echo "<div class=\"container\">";
if (!$student_holds_record) {
    echo "<h2>Student not on hold</h2>";
} else {
    ?>
    <table class="table">
        <tr>
            <th>Hold Name</th>
            <th>Hold Type</th>
            <th>Hold Description</th>
        </tr>
        <tr>
            <td><?= $student_holds_record['HoldName']  ?></td>
            <td><?= $student_holds->getValue('TypeOfHold', 'Holds')  ?></td>
            <td><?= $student_holds->getValue('DescriptionOfHold', 'Holds')  ?></td>
        </tr>
    </table>
    <?php
}
echo "</div>";
include_once 'footer.php';

