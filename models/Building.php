<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Building extends Model
{
    public function __construct()
    {
        parent::__construct("Building", "BuildingIDNumber");
    }
}
