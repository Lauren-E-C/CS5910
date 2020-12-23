<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Faculty extends Model
{
    public function __construct()
    {
        parent::__construct("Faculty", ["FacultyID", "DepartmentID"]);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $department = new Department();
        $department->get([
            'DepartmentID' => $values['DepartmentID']
        ]);
        $this->related['Department'] = $department;

        $building = new Building();
        $building->get([
            'BuildingIDNumber' => $values['BuildingID']
        ]);
        $this->related['Building'] = $building;
    }
}
