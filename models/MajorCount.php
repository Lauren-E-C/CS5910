<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class MajorCount extends Model
{
    public function __construct()
    {
        parent::__construct("MajorCount", "MajorName");
    }
}
