<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';
if (!isset($user_nav)) {
    $user_nav = [];
}
if (isset($_SESSION['u_type']) && isset($user_nav[$_SESSION['u_type']])) {
    $nav_array = $user_nav[$_SESSION['u_type']];
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
<!--        <a class="navbar-brand" href="#">Lake Royal University</a>-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
<!--                <li class="nav-item active">-->
<!--                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
<!--                </li>-->

                <?php foreach ($nav_array as $top_nav_name => $sub_nav_items) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <?= $top_nav_name ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($sub_nav_items as $sub_nav_name => $sub_nav_link) { ?>
                                <a class="dropdown-item" href="<?= $sub_nav_link ?>"><?= $sub_nav_name ?></a>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <span style="margin-right: 10px;"><?= $_SESSION["u_data"]['firstName'] ?> <?= $_SESSION["u_data"]['lastName'] ?>   </span>
<!--                <button class="btn btn-outline-success my-2 my-sm-0" style="margin-right: 10px;" type="submit">Change Password</button>-->
                <a href="passwd.php" style="margin-right: 10px;" class="btn btn-outline-success my-2 my-sm-0" >Change Password</a>
                <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0" >Logout</a>
            </form>
        </div>
    </nav>
<?php } ?>