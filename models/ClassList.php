<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class ClassList extends Model
{
    public function __construct()
    {
        parent::__construct("ClassList", ["StudentID", "CourseRegistrationNumber"]);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $student = new Users();
        $student->get([
            'ID' => $values['StudentID']
        ]);
        $this->related['Student'] = $student;

        $faculty = new Users();
        $faculty->get([
            'ID' => $values['FacultyID']
        ]);
        $this->related['Faculty'] = $faculty;

        $section = new Section();
        $key = $values['CourseRegistrationNumber'];
        $x = $section->get([
            'CourseRegistrationNumber' => $key
        ]);
        if (!$x) echo "Section $key does not exist";
        $this->related['Section'] = $section;

        $course = new Course();
//        $course->setDebugger(true);
        $key = $section->getValue('CourseID');
        $x = $course->get([
            'courseID' => $key
        ]);
        if (!$x) echo "Course |$key| does not exist";
        $this->related['Course'] = $course;

        $enrollment = new Enrollment();
        $x = $enrollment->get([
            'StudentID' => $values['StudentID'],
            'CourseRegistrationNumber' => $values['CourseRegistrationNumber']
        ]);
#        if (!$x) echo "Enrollment not found: " . $values['StudentID'] . " " . $values['CourseRegistrationNumber'];
        $this->related['Enrollment'] = $enrollment;

        $timeslot = new TimeSlot();
        $key = $section->getValue('TimeSlotNum');
        $x = $timeslot->get([
            'ID' => $key
        ]);
        if (!$x) echo "TimeSlot $key does not exist";
        $this->related['TimeSlot'] = $timeslot;
    }
}
