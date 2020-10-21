<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Faculty extends Model
{
    public function __construct()
    {
        parent::__construct("Faculty", "PRIMARY_KEY");
    }
}
