<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class CurrentTerm extends Model
{
    public function __construct()
    {
        parent::__construct("CurrentTerm", ["Semester", "Year" ]);
    }
}
