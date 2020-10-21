<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class CourseHistoryOfStudent extends Model
{
    public function __construct()
    {
        parent::__construct("CourseHistoryOfStudent", "PRIMARY_KEY");
    }
}
