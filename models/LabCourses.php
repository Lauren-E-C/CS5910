<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class LabCourses extends Model
{
    public function __construct()
    {
        parent::__construct("LabCourses", "CourseRegistrationNumber");
    }
}
