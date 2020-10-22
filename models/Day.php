<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Day extends Model
{
    public function __construct()
    {
        parent::__construct("Day", "NameOfDay");
    }
}
