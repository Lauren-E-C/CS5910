<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Department extends Model
{
    public function __construct()
    {
        parent::__construct("Department", "DepartmentID");
    }
}
