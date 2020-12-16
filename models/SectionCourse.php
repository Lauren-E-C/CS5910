<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class SectionCourse extends Model
{
    public function __construct()
    {
        parent::__construct("SectionCourse", ['CourseRegistrationNumber', 'CourseID']);
    }

    public function getRelated($values)
    {

    }
}
