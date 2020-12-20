<?php
$roles = ['Researcher'];
$page_title = "Computer Science Majors";
include 'header.php';

?>
<div class="container"><?php
    $g = new Grid(new CompSciMajor(), [
        'CompSciMajor' => 'Major',
        'CompSciCount' => 'Count'
    ]);

    $g->showGrid();
    ?>
</div>
<?php include_once 'footer.php' ?>
