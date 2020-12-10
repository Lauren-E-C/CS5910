<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class CourseCatalog extends Model
{
    public function __construct()
    {
        parent::__construct("CourseCatalog", "courseID");
    }
}
