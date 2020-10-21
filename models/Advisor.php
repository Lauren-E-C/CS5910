<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Advisor extends Model
{
    public function __construct()
    {
        parent::__construct("Advisor", "PRIMARY_KEY");
    }
}
