<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Attendance extends Model
{
    public function __construct()
    {
        parent::__construct("Attendance", "PRIMARY_KEY");
    }
}
