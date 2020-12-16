<?php
$roles = ['Student'];
include_once 'header.php';

$student_id = null;


$student_id = $_SESSION["u_data"]["ID"];

$student_major = new StudentMajor();
$student_major_record = $student_major->get([
    'StudentID' => $student_id
]);

if (!$student_major_record) {
    echo "Student has not declared major<br>";
} else {
    $student_major_name = $student_major_record['MajorName'];
}

$enrollments = array();
$enrollment = new Enrollment();
for ($enrollment_record = $enrollment->get(['StudentID' => $student_id]); $enrollment_record; $enrollment_record = $enrollment->next()) {
    $enrollment_record['Section'] = $enrollment->getRelatedModel('Section')->getValues();
    $enrollment_record['Course'] = $enrollment->getRelatedModel('Course')->getValues();

    $course_id = $enrollment->getValue('CourseID', 'Section');
//    echo "<pre>";echo "<p>Course ID: $course_id</p>";
//    echo "</pre>";

    $enrollments[$course_id] = $enrollment_record;
//    var_dump($enrollments[$course_id]);
}

//echo "<pre>";
//print_r($enrollments);
//echo "</pre>";
?>
    <div class="container-fluid">
        <table class="table">
            <caption style="caption-side: top;">Major: <?= $student_major_name ?></caption>
            <thead>
            <tr>
                <th>Course ID</th>
                <th>Requirement</th>
                <th>Credits</th>
                <th>Grade Received</th>
                <th>Minimum Grade</th>
                <!--                <th>Requirement Type</th>-->
                <th>Filled?</th>
            </tr>
            </thead>
            <tbody>


            <?php
            // retrieve all of the requirements for the student's major
            $major_credits = 0;
            $core_credits = 0;
            $received_credits = 0;
            $taken_credits = 0;
            $received_major_credits = 0;
            $requirement_type = "";
            $major_requirements = new MajorRequirements();
            for ($major_requirements_record = $major_requirements->get(['MajorName' => $student_major_name]); $major_requirements_record; $major_requirements_record = $major_requirements->next()) {
                $course_id = $major_requirements_record['CourseID'];
                $course_name = $major_requirements->getValue('coursename', 'Course');
                $course_credits = $major_requirements->getValue('credits', 'Course');
                $grade_required = $major_requirements->getValue('GradeRequirement');


                if ($major_requirements->getValue('CoreRequirement')) {
                    $core_credits += $course_credits;
                    $requirement_type = "Core";
                } else {
                    $major_credits += $course_credits;
                    $requirement_type = "Major";
                }

                $fulfilled = 'No';
                $grade_received = "Not taken";
                if (isset($enrollments[$course_id])) {
                    $taken_credits += $course_credits;
                    $grade_received = $enrollments[$course_id]['Final_Grade'];

                    $required_quality = $enrollment->computeQuality($grade_required);

                    $received_quality = 0;
                    if ($grade_received) {
                        $received_quality = $enrollment->computeQuality($grade_received);
                    }
                    else {
                        $grade_received = "In Progress";
                        $received_quality = 0;
                    }

                    if ($received_quality >= $required_quality) {
                        $fulfilled = "Yes";
                        $received_credits += $course_credits;
                        if ($major_requirements->getValue('CoreRequirement')) {
                            $received_major_credits += $core_credits;
                        }
                    }
                }
                ?>
                <tr>
                    <td><?= $course_id ?></td>
                    <td><?= $course_name ?></td>
                    <td><?= $course_credits ?></td>
                    <td><?= $grade_received ?></td>
                    <td><?= $grade_required ?></td>
                    <!--                    <td>--><?//= $requirement_type ?><!--</td>-->
                    <td><?= $fulfilled ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Total Credits<br>Taken</th>
                <th>Total Credits<br>Recieved</th>
                <th>Credits<br>Taken</th>
                <th>Credits<br>Recieved</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $core_credits + $major_credits ?></td>
                <td><?php echo $received_credits ?></td>
                <td><?php echo $major_credits ?></td>
                <td><?php echo $received_major_credits ?></td>
            </tr>
            </tbody>
        </table>
    </div>

<?php include_once 'footer.php'; ?>