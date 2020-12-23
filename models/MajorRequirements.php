<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class MajorRequirements extends Model
{
    public function __construct()
    {
        parent::__construct("MajorRequirements", ['MajorName', 'CourseID']);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $course = new Course();
//        $course->setDebugger(true);
        $key = $values['CourseID'];
        $x = $course->get([
            'courseID' => $key
        ]);
//        echo "<pre>";
//        var_dump($key);
//        var_dump($x);
//        echo "</pre>";
        if (!$x) echo "<pre>Course |$key| does not exist</pre><br>\n";
        $this->related['Course'] = $course;
    }
}
