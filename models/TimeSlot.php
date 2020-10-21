<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class TimeSlot extends Model
{
    public function __construct()
    {
        parent::__construct("TimeSlot", "PRIMARY_KEY");
    }
}
