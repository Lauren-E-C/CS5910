<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class MinorRequirements extends Model
{
    public function __construct()
    {
        parent::__construct("MinorRequirements", "PRIMARY_KEY");
    }
}
