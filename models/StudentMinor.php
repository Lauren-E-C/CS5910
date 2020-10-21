<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class StudentMinor extends Model
{
    public function __construct()
    {
        parent::__construct("StudentMinor", "PRIMARY_KEY");
    }
}
