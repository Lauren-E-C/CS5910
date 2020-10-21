<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Prerequisites extends Model
{
    public function __construct()
    {
        parent::__construct("Prerequisites", "PRIMARY_KEY");
    }
}
