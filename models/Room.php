<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Room extends Model
{
    public function __construct()
    {
        parent::__construct("Room", "PRIMARY_KEY");
    }
}
