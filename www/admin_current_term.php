<?php
$roles = ['Admin'];
include_once 'header.php';

$id = $_SESSION["u_data"]["ID"];

$current_term = new CurrentTerm();
$term_record = $current_term->get([
    'ID' => 1
]);


?>
<!--    <div class="container">-->
<!--        <table class="table">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>Current<br>Semester</th>-->
<!--                <th>Current<br>Year</th>-->
<!--                <th>Current<br>Exam</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr>-->
<!--                <td>--><?php //echo $current_term->getValue('Semester'); ?><!--</td>-->
<!--                <td>--><?php //echo $current_term->getValue('Year'); ?><!--</td>-->
<!--                <td>--><?php //echo $current_term->getValue('Exam'); ?><!--</td>-->
<!--            </tr>-->
<!--            </tbody>-->
<!--        </table>-->
<!--    </div>-->
<?php

echo "<div class='container'>";
$f = new Form();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $f->setValues($term_record);
}

$term_form_data = $f->showForm([
    'Semester' => new SelectField('Semester', ['Winter', 'Spring', 'Summer', 'Fall']),
    'Year' => new SelectField('Year', ['2020', '2021', '2022', '2023', '2024', '2025']),
    'Exam' => new SelectField('exam', ['Midterm', 'Final']),
]);

if (isset($_GET['save'])) {
    try {
        $current_term->update($term_form_data);
        ?><div class="alert alert-success" role="alert">Semester/Term updated</div><?php
    } catch (Exception $e) { ?>
        <div class="alert alert-danger" role="alert"><?php echo $e->getMessage(); ?></div>
    <?php }
}
echo "</div>";
include_once 'footer.php';