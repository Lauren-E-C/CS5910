<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class YearOfSemester extends Model
{
    public function __construct()
    {
        parent::__construct("YearOfSemester", "PRIMARY_KEY");
    }
}
