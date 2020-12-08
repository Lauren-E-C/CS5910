<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Holds extends Model
{
    public function __construct()
    {
        parent::__construct("Holds", "HoldName");
    }
}
