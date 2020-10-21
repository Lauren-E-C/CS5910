<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Section extends Model
{
    public function __construct()
    {
        parent::__construct("Section", "PRIMARY_KEY");
    }
}
