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
        $id = $values['ChairpersonID'];
//        if (!$id) throw new Exception("Department ChairpersonID is null");
        $r = $chairperson->get([
            'ID' => $id
        ]);
//        if (!$r) throw new Exception("Department ChairpersonID $id not found");
        $this->related['Chairperson'] = $chairperson;

        $manager = new Users();
        $id = $values['ManagerID'];
//        if (!$id) throw new Exception("Department ManagerID is null");
        $r = $manager->get([
            'ID' => $id
        ]);
//        if (!$r) throw new Exception("Department ManagerID $id not found");
        $this->related['Manager'] = $manager;

        $building = new Building();
        $id = $values['BuildingID'];
//        if (!$id) throw new Exception("Department BuildingID is null");
        $r = $building->get([
            'BuildingIDNumber' => $id
        ]);
//        if (!$r) throw new Exception("Department BuildingID $id not found");
        $this->related['Building'] = $building;
    }
}
