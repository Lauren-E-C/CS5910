<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class StudentMajor extends Model
{
    public function __construct()
    {
        parent::__construct("StudentMajor", "PRIMARY_KEY");
    }
}
