<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Advisor extends Model
{
    public function __construct()
    {
        parent::__construct("Advisor", ['FacultyID', 'StudentID']);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $student = new Users();
        $student->get([
            'ID' => $values['StudentID']
        ]);
        $this->related['Student'] = $student;
    }
}
