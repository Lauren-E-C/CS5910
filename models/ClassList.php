<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class ClassList extends Model
{
    public function __construct()
    {
        parent::__construct("ClassList", "PRIMARY_KEY");
    }
}
