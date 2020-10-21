<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Researchers extends Model
{
    public function __construct()
    {
        parent::__construct("Researchers", "PRIMARY_KEY");
    }
}
