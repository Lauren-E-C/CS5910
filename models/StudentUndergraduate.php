<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class StudentUndergraduate extends Model
{
    public function __construct()
    {
        parent::__construct("StudentUndergraduate", "PRIMARY_KEY");
    }
}
