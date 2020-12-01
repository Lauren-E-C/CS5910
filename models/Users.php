<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Users extends Model
{
    public function __construct()
    {
        parent::__construct("usertable", "ID");
    }

    public function allow($permission) {

        if ($permission == "section_view") {
            return true;
        }

        return false;
    }
}