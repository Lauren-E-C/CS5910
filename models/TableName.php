<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class TableName extends Model
{
    public function __construct()
    {
        parent::__construct("table_name", "column_1");
    }
}