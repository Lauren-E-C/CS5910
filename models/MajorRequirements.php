<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class MajorRequirements extends Model
{
    public function __construct()
    {
        parent::__construct("MajorRequirements", "PRIMARY_KEY");
    }
}
