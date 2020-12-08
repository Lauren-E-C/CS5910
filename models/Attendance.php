<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Attendance extends Model
{
    public function __construct()
    {
        parent::__construct("Attendance", ['StudentID', 'CourseRegistrationNumber', 'Date']);
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
