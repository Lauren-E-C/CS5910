<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class FacultyPartTime extends Model
{
    public function __construct()
    {
        parent::__construct("FacultyPartTime", "PRIMARY_KEY");
    }
}
