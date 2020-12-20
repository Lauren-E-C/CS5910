<?php
$roles = ['Student','Admin', 'Researcher', 'Instructor'];
include_once 'header.php';
?>
    <div class="container">
        <h1>Change Password</h1>
        <?php
        $f = new Form();
        $password_data = $f->showForm([
            'password1' => new PasswordField('New Password'),
            'password2' => new PasswordField('Reenter Password'),
        ]);

        if ($password_data) {
            if ($password_data['password1'] == $password_data['password2']) {
                $id = $_SESSION["u_data"]["ID"];
                $users = new Users();
                $user_record = $users->get([
                    'ID' => $id
                ]);
                if ($user_record) {
                    try {
                        $users->update([
                            'pWord' => $password_data['password1']
                        ]); ?>
                        <div class="alert alert-success" role="alert">Password changed</div>
                    <?php } catch (Exception $e) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $e->getMessage(); ?></div>
                    <?php }
                } else { ?>
                    <div class="alert alert-danger" role="alert">Internal error, user id not found</div>
                <?php }
            } else { ?>
                <div class="alert alert-danger" role="alert">Passwords do not match</div>
            <?php }
        }
        ?>
    </div>
<?php
include_once 'footer.php';
