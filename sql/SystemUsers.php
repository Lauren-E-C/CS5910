<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class SystemUsers extends Model
{
    public function __construct()
    {
        parent::__construct("SystemUsers", "PRIMARY_KEY");
    }
}
