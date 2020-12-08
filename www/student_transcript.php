<?php
$roles = ['Student'];
$page_title = "Student Transcript";
include_once 'header.php';

$term_form = new Form("get");

$class_list = new ClassList();
$terms = $class_list->getUnique('TermNumber', [
    'StudentID' => $_SESSION["u_data"]["ID"]
]);

$term_field = new SelectField("Term", $terms);
$term_data = $term_form->showForm([
    'Term' => $term_field
]);

if ($term_data) {
    $term = $term_data['Term'];

    $class_list_grid = new Grid(new ClassList(), [
        ':r_01' => ['Course', 'Course', 'coursenumber'],
        ':r_02' => ['Department', 'Course', 'departmentcode'],
        ':r_03' => ['Course<br>Name', 'Course', 'coursename'],
        ':r_04' => ['Credits', 'Course', 'credits'],
        ':r_05' => ['Grade', 'Enrollment', 'Final_Grade'],
        ':r_06' => ['Quality<br>Points', 'Enrollment', 'Final_Quality'],
    ]);

    $class_list_grid->showGrid([
        'StudentID' => $_SESSION["u_data"]["ID"],
        'TermNumber' => $term
    ]);

    //
    $class_term_list = new ClassList();
    //
    $class_list_record = $class_list->get([
        'StudentID' => $_SESSION["u_data"]["ID"]
    ]);

    $count_term = 0;
    $credits_term_total = 0;
    $credits_term_earned = 0;
    $quality_term_total = 0;

    $count_all = 0;
    $credits_all_total = 0;
    $credits_all_earned = 0;
    $quality_all_total = 0;

    for ($r = $class_term_list->get(['StudentID' => $_SESSION["u_data"]["ID"]]); $r; $r = $class_term_list->next()) {
        $count_all++;

        $credits = $class_list->getValue('credits', 'Course');
        $quality_points = $class_list->getValue('Final_Quality', 'Enrollment');
        $grade = $class_list->getValue('Final_Grade', 'Enrollment');

        if ($grade) {
            $credits_all_earned += $credits;
        }
        $credits_all_total += $credits;
        $quality_all_total += $quality_points;

        if ($class_list->getValue('TermNumber') == $term) {
            $count_term++;

            if ($grade) {
                $credits_term_earned += $credits;
            }
            $credits_term_total += $credits;
            $quality_term_total += $quality_points;
        }

        $class_list->next();
    }

    $gpa_term = ($quality_term_total * 3) / $credits_term_earned;
    $gpa_all = ($quality_all_total * 3) / $credits_all_earned;

    ?>
    <br>
    <hr>
    <!--    <div id="transcript_table" class="container">-->
    <div class="container">
        <table class="table">
            <tr>
                <th>Credits Taken in Term</th>
                <th>Credits Earned in Term</th>
                <th>Term Quality Points</th>
                <th>Term GPA</th>
            </tr>
            <tr>
                <td><?= $credits_term_total ?></td>
                <td><?= $credits_term_earned ?></td>
                <td><?= $quality_term_total ?></td>
                <td><?= $gpa_term ?></td>
            </tr>
            <tr>
                <th>Cumulative Credits Taken</th>
                <th>Cumulative Credits Earned</th>
                <th>Cumulative Quality Points</th>
                <th>Cumulative GPA</th>
            </tr>
            <tr>
                <td><?= $credits_all_total ?></td>
                <td><?= $credits_all_earned ?></td>
                <td><?= $quality_all_total ?></td>
                <td><?= $gpa_all ?></td>
            </tr>
        </table>
    </div>


    <?php
}
include_once 'footer.php';

