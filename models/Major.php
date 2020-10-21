<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Major extends Model
{
    public function __construct()
    {
        parent::__construct("Major", "PRIMARY_KEY");
    }
}
