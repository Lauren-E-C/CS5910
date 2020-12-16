<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Users extends Model
{
    public function __construct()
    {
        parent::__construct("usertable", "ID");
    }

    public function allow($permission) {

        if ($permission == "section_view") {
            return true;
        }

        return false;
    }


    public function getKeyValues($key, $value, $filter = false)
    {
        $values = array();

        $record = $this->get($filter);  // get first record
        while ($record) {   // loop until no more data
            $values[$this->getValue($key)] = $this->getValue('firstName') . ' ' . $this->getValue('lastName');
            $record = $this->next();
        }
        return $values;
    }

}