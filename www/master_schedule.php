<?php include 'header.php' ?>
<?php $g = new Course(); ?>

<h1 style="margin: 20px; padding 20px;">Master Schedule</h1>
<p style="margin: 20px; padding 20px;">Quod equidem non reprehendo; Partim cursu et peragratione laetantur, congregatione aliae
    coetum quodam modo civitatis imitantur; </p>

<?php $g->makeCombo("CourseID", "Course ID"); ?>
<?php include 'footer.php' ?>

