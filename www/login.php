<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isset($_SESSION["u_type"])) {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

        $err = "Invalid username or password";

        $user = new Users();

        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($username) {
            $u = $user->get([
                'email' => $username
            ]);

            if ($u && $u["pWord"] == $password && $u["uLocked"] == "No") {
                $_SESSION["u_type"] = $u["uType"];
                $_SESSION["u_data"] = $u;
                $page = "denied.php";
                if (isset($user_pages[$_SESSION["u_type"]])) {
                    $page = $user_pages[$_SESSION["u_type"]];
                }
                header("Location: $page");
                exit;
            }
        }
    }
} else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';
    if (isset($_SESSION['u_type'])) {
        if (isset($user_pages[$_SESSION["u_type"]])) {
            $page = $user_pages[$_SESSION["u_type"]];
        }
        header("Location: $page");
        exit;
    }
}
?>
<?php
$page_title = "Login";
include 'header.php';
?>
<div class="top">

    <div class="login">
        <form method="post">
            <table>
                <tr>
                    <td class="login-td">Username:</td>
                    <td class="login-td"><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td class="login-td">Password:</td>
                    <td class="login-td"><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit"></td>
                </tr>
                <?php if (isset($err) && $err) { ?>
                    <tr>
                        <td colspan="2">
                            <div class="alert alert-danger" role="alert">
                                <?= $err ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
