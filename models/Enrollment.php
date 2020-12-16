<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Enrollment extends Model
{
    protected $quality_points = array(
        'A' => 4.0,
        'A-' => 3.67,
        'B+' => 3.33,
        'B' => 3.0,
        'B-' => 2.67,
        'C+' => 2.33,
        'C' => 2.00,
        'C-' => 1.67,
        'D+' => 1.33,
        'D' => 1.0,
        'D-' => 0.67,
        'F' => 0
    );

    public function __construct()
    {
        parent::__construct("Enrollment", ["CourseRegistrationNumber", "StudentID"]);
    }

    public function getGrades()
    {
        $grades = array();
        foreach ($this->quality_points as $key => $value) {
            $grades[] = $key;
        }
        return $grades;
    }

    public function computeQuality($grade)
    {
        if (!isset($this->quality_points[$grade])) throw new Exception("Invalid grade: $grade ");

        return $this->quality_points[$grade];
    }

    public function update($values = false)
    {
        if ($values) {
            $this->setValues($values);
        }

        $midterm_grade = $this->getValue('Midterm_Grade');
        if ($midterm_grade) {
            $this->setValue('Midterm_Quality', $this->computeQuality($midterm_grade));
        }

        $final_grade = $this->getValue('Final_Grade');
        if ($final_grade) {
            $this->setValue('Final_Quality', $this->computeQuality($final_grade));
        }

        parent::update($values);
    }

    public function create($values = false)
    {
        if ($values) {
            $this->setValues($values);
        }

        $midterm_grade = $this->getValue('Midterm_Grade');
        if ($midterm_grade) {
            $this->setValue('Midterm_Quality', $this->computeQuality($midterm_grade));
        }

        $final_grade = $this->getValue('Final_Grade');
        if ($final_grade) {
            $this->setValue('Final_Quality', $this->computeQuality($final_grade));
        }

        parent::create($values);
    }

    public function getRelated($values)
    {
        $this->related = [];

        $section = new Section();
        $key = $values['CourseRegistrationNumber'];
        $x = $section->get([
            'CourseRegistrationNumber' => $key
        ]);
        if (!$x) echo "Section $key does not exist";
        $this->related['Section'] = $section;

        $course = new Course();
        $key = $section->getValue('CourseID');
        $x = $course->get([
            'courseID' => $key
        ]);
        if (!$x) echo "Course $key does not exist";
        $this->related['Course'] = $course;
    }
}
