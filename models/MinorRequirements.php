<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class MinorRequirements extends Model
{
    public function __construct()
    {
        parent::__construct("MinorRequirements", ['MinorName', 'CourseID']);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $section = new Course();
        $key = $values['CourseID'];
        $x = $section->get([
            'courseID' => $key
        ]);
        if (!$x) echo "Course $key does not exist";
        $this->related['Course'] = $section;
    }
}
