<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Section extends Model
{
    public function __construct()
    {
        parent::__construct("Section", "CourseRegistrationNumber");
    }

    public function getRelated($values)
    {
        $this->related = [];

        $course = new Course();
        $course->get([
            'courseID' => $values['CourseID']
        ]);
        $this->related['Course'] = $course;
    }
}
