<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class NightSection extends Model
{
    public function __construct()
    {
        parent::__construct("NightSection", "CourseRegistrationNumber");
    }

    public function getRelated($values)
    {
        $this->related = [];

        $course = new Course();
        $course->get([
            'courseID' => $values['CourseID']
        ]);
        $this->related['Course'] = $course;

        $faculty = new Users();
        $faculty->get([
            'ID' => $values['FacultyID']
        ]);
        $this->related['Faculty'] = $faculty;

        $time_slot = new TimeSlot();
        $time_slot->get([
            'ID' => $values['TimeSlotNum']
        ]);
        $this->related['TimeSlot'] = $time_slot;
    }
}
