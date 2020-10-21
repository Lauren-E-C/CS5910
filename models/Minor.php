<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Minor extends Model
{
    public function __construct()
    {
        parent::__construct("Minor", "PRIMARY_KEY");
    }
}
