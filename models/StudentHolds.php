<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class StudentHolds extends Model
{
    public function __construct()
    {
        parent::__construct("StudentHolds", "StudentID");
    }

    public function getRelated($values)
    {
        $this->related = [];

        $section = new Holds();
        $key = $values['HoldName'];
        $x = $section->get([
            'HoldName' => $key
        ]);
        if (!$x) echo "Holds $key does not exist";
        $this->related['Holds'] = $section;
    }
}
