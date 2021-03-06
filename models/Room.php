<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Room extends Model
{
    private $specialRooms = array(
        'TBA' => 'To Be Announced',
        'WEB' => '100% web, no face to face',
        'OFF' => 'Off campus'
    );

    public function __construct()
    {
        parent::__construct("Room", ["RoomID", "BuildingIDNumber"]);
    }

//    public function get($keyValues = false)
//    {
//        if ($keyValues && isset($specialRooms['RoomID'])) {
//            $roomID = $keyValues['RoomID'];
//            if (isset($this->specialRooms[$roomID])) {
//                $this->setValues([
//                    'RoomID' => $roomID,
//                    'BuildingIDNumber' => null,
//                    'RoomSize' => 0,
//                    'RoomType' => $this->specialRooms[$roomID]
//                ]);
//            }
//            return $this->getValues();
//        }
//
//        return parent::get($keyValues);
//    }
}
