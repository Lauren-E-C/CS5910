<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Students extends Model
{
    public function __construct()
    {
        parent::__construct("Students", "PRIMARY_KEY");
    }
}
