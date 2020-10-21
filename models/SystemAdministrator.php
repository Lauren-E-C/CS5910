<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class SystemAdministrator extends Model
{
    public function __construct()
    {
        parent::__construct("SystemAdministrator", "PRIMARY_KEY");
    }
}
