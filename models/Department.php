<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Department extends Model
{
    public function __construct()
    {
        parent::__construct("Department", "DepartmentID");
    }

    public function getRelated($values)
    {
        $this->related = [];

        $chairperson = new Users();
        $chairperson->get([
            'ID' => $values['ChairpersonID']
        ]);
        $this->related['Chairperson'] = $chairperson;

        $manager = new Users();
        $manager->get([
            'ID' => $values['ManagerID']
        ]);
        $this->related['Manager'] = $manager;
    }
}
