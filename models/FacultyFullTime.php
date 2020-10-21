<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class FacultyFullTime extends Model
{
    public function __construct()
    {
        parent::__construct("FacultyFullTime", "PRIMARY_KEY");
    }
}
