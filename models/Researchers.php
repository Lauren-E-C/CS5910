<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Researchers extends Model
{
    public function __construct()
    {
        parent::__construct("Researchers", "ResearcherID");
    }

    public function getRelated($values)
    {
        $this->related = [];

        $researchers = new Users();
        $researchers->get([
            'ID' => $values['ResearcherID']
        ]);
        $this->related['Researcher'] = $researchers;
    }
}
