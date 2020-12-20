<?php
include_once 'admin_manage_researcher_header.php';

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
