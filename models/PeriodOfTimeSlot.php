<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class PeriodOfTimeSlot extends Model
{
    public function __construct()
    {
        parent::__construct("PeriodOfTimeSlot", "PRIMARY_KEY");
    }
}
