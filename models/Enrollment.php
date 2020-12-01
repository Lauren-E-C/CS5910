<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Enrollment extends Model
{
    public function __construct()
    {
        parent::__construct("Enrollment", ["CourseRegistrationNumber", "StudentID"]);
    }
}
