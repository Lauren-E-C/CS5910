<?php
$roles = ['Admin'];
$page_title = "Unlock User Form";
include_once 'header.php';

if (isset($_GET["ID"])) {
    $id = $_GET["ID"];

    $user = new Users();
    $user_data = $user->get([
        'ID' => $id
    ]);
    if ($user_data) {
        if (isset($_GET["unlock"])) {
            $user_data['uLocked'] = 'No';
            $user_data['failedLogins'] = 0;

            $user->update([
                'uLocked' => $user_data['uLocked'],
                'failedLogins' => $user_data['failedLogins']
            ]);
        }
        ?>
        <div class="container" style="border: 1px black">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Locked</th>
                    <th>Failed Attempts</th>
                </tr>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $user_data['firstName'] ?></td>
                    <td><?= $user_data['lastName'] ?></td>
                    <td><?= $user_data['uLocked'] ?></td>
                    <td><?= $user_data['failedLogins'] ?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td><a href="?unlock&ID=<?= $id ?>" class="btn btn-success my-2 my-sm-0">Unlock</a></td>
                </tr>
            </table>
        </div>
        <?php
    }
}
