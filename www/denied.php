<?php
include 'header.php';

$page = "denied.php";
if (isset($user_pages[$_SESSION["u_type"]])) {
    $page = $user_pages[$_SESSION["u_type"]];
}?>
<div class="top">

    <div class="page_denied">
        <table>
            <tr>
                <td colspan="2">
                    <h1>Access denied</h1>
                    <p>You do not have permission to access the page.</p>
                    <p><a href="<?= $page ?>" class="btn btn-warning my-2 my-sm-0">Home</a> </p>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
