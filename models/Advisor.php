<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Advisor extends Model
{
    public function __construct()
    {
//        parent::__construct("Advisor", ['FacultyID', 'StudentID']);
        parent::__construct("Advisor", ['StudentID']);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $student = new Users();
        $student->get([
            'ID' => $values['StudentID']
        ]);
        $this->related['Student'] = $student;

        $advisor = new Users();
        $advisor->get([
            'ID' => $values['FacultyID']
        ]);
        $this->related['Advisor'] = $advisor;


        $student = new StudentHolds();
        $student->get([
            'StudentID' => $values['StudentID']
        ]);
        $this->related['StudentHolds'] = $student;

        $faculty = new Faculty();
        $faculty->get([
            'FacultyID' => $values['FacultyID']
        ]);
        $this->related['Faculty'] = $faculty;


        $building = new Building();
        $building->get([
            'BuildingIDNumber' => $faculty->getValue('BuildingID')
        ]);
        $this->related['Building'] = $building;
    }
}
