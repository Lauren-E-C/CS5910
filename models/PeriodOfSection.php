<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class PeriodOfSection extends Model
{
    public function __construct()
    {
        parent::__construct("PeriodOfSection", "PRIMARY_KEY");
    }
}
