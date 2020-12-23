<?php
$roles = ['Student', 'Admin', 'Researcher', 'Instructor'];
include_once 'header.php';

$id = $_SESSION["u_data"]["ID"];

$advisor = new Advisor();
$advisor_record = $advisor->get([
    'StudentID' => $id
]);

if ($advisor_record) {
    ?>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Advisor<br>First Name</th>
                <th>Advisor<br>Last Name</th>
                <th>Date<br>Assigned</th>
                <th>Phone<br>Number</th>
                <th>Building</th>
                <th>Room<br>Number</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($advisor_record) { ?>
                <tr>
                    <td><?php echo $advisor->getValue('firstName', 'Advisor'); ?></td>
                    <td><?php echo $advisor->getValue('lastName', 'Advisor'); ?></td>
                    <td><?php echo preg_replace('/ .*/', '', $advisor->getValue('AssignedDate')); ?></td>
                    <td><?php echo $advisor->getValue('phoneNumber', 'Advisor'); ?></td>
                    <td><?php echo $advisor->getValue('BuildingName', 'Building'); ?></td>
                    <td><?php echo $advisor->getValue('RoomID', 'Faculty'); ?></td>
                </tr>
                <?php
                $advisor_record = $advisor->next();
            }
            ?>
            </tbody>
        </table>
    </div>
<?php } else {
    ?>
    <h2>&nbsp;&nbsp;No advisors assigned</h2>
    <?php
}
include_once 'footer.php';