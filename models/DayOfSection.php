<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class DayOfSection extends Model
{
    public function __construct()
    {
        parent::__construct("DayOfSection", "PRIMARY_KEY");
    }
}
