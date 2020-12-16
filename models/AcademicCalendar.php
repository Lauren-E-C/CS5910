<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class AcademicCalendar extends Model
{
    public function __construct()
    {
        parent::__construct("AcademicCalendar", "ID");
    }
}