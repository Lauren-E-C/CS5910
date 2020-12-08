<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Minor extends Model
{
    public function __construct()
    {
        parent::__construct("Minor", "MinorName");
    }

    public function getRelated($values)
    {
        $this->related = [];

        $department = new Department();
        $department->get([
            'DepartmentID' => $values['DepartmentID']
        ]);
        $this->related['Department'] = $department;
    }
}