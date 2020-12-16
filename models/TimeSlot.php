<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';



class TimeSlot extends Model
{
    public function parseTime($time)
    {
        $time = preg_replace('/ /', '', $time);
        list($time_hours, $time_mins) = preg_split("/:/", $time);
        if (preg_match('/pm/', $time_mins) && $time_hours != 12) {
            $time_hours += 12;
        }
        return $time_hours . ":" . $time_mins;
    }

    public function __construct()
    {
        parent::__construct("TimeSlotNew", "ID");
    }

    public function getKeyValues($key, $value, $filter = false)
    {
        $values = array();

        $record = $this->get($filter);  // get first record
        while ($record) {   // loop until no more data
            $values[$this->getValue($key)] = $this->getValue('DaysOfWeek') . ': ' . $this->getValue('StartTime') . '-' . $this->getValue('EndTime');
            $record = $this->next();
        }
        return $values;
    }

}
