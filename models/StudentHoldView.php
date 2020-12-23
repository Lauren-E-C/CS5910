<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class StudentHoldView extends Model
{
    public function __construct()
    {
        parent::__construct("StudentHoldView", "ID");
    }
}
