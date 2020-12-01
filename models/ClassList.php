<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class ClassList extends Model
{
    public function __construct()
    {
        parent::__construct("ClassList", ["StudentID", "CourseRegistrationNumber"]);
    }


//X CRN
//X Department
//X Course Number
//X Course Section
//X Course Name
//Room Number
//X Instructor
//Day
//Time

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
        $key = $section->getValue('CourseID');
        $x = $course->get([
            'coursenumber' => $key
        ]);
        if (!$x) echo "Course $key does not exist";
        $this->related['Course'] = $course;

        $timeslot = new TimeSlot();
        $key = $section->getValue('TimeSlotNum');
        $x = $timeslot->get([
            'ID' => $key
        ]);
        if (!$x) echo "TimeSlot $key does not exist";
        $this->related['TimeSlot'] = $timeslot;
    }
}
