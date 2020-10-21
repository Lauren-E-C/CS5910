<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class DayOfTimeSlot extends Model
{
    public function __construct()
    {
        parent::__construct("DayOfTimeSlot", "PRIMARY_KEY");
    }
}
