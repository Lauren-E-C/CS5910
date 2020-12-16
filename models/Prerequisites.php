<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Prerequisites extends Model
{
    public function __construct()
    {
        parent::__construct("Prerequisites", ["CourseID", "PreqCourseID"]);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $course = new Course();
        $course->get([
            'courseID' => $values['CourseID']
        ]);
        $this->related['Course'] = $course;

        $preq_course = new Course();
        $preq_course->get([
            'courseID' => $values['PreqCourseID']
        ]);
        $this->related['PreqCourse'] = $preq_course;
    }
}
