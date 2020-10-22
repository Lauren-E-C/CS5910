<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Course extends Model
{
    public function __construct()
    {
        parent::__construct("Course", "CourseID");
    }


}
