<?php
function building_room($room_id = false)
{
// -- Building Field
    $building = new Building();
    $building_values = $building->getKeyValues('BuildingIDNumber', 'BuildingName');
    $building_field = new KeyValueField('Building', $building_values);
    $building_field->setOnChange('buildingChange');

// -- Room field
    $room_field = new SelectField('Room', []);

// -- get the rooms for each building
    $building = new Building();
    $building_rooms = array();
    $building_record = $building->get();
    while ($building_record) {
        $building_id = $building->getValue('BuildingIDNumber');

        $building_rooms[$building_id] = array();
        $room = new Room();
        $room_record = $room->get([
            'BuildingIDNumber' => $building_id
        ]);

        while ($room_record) {
            $building_rooms[$building_id][] = $room->getValue('RoomID');
            $room_record = $room->next();
        }
        $building_record = $building->next();
    }
    ?>

    <script>
        $( document ).ready(function() {
            console.log( "ready!" );

            var building_rooms = [];
            <?php
            if ($room_id) {
                echo "var room_id = $room_id;\n";
            } else {
                echo "var room_id = null;\n";
            }
            echo "\n";
            foreach ($building_rooms as $building_key => $rooms) {
                echo "building_rooms[\"$building_key\"]= [";
                foreach ($rooms as $room) {
                    echo "\"$room\", ";
                }
                echo "];\n";
            }
            ?>

            var building_select = $('#BuildingIDNumber').get(0); // TODO: examin other building/room
            if (building_select === undefined) {
                console.log('Could not find BuildingIDNumber, looking for BuildingID');
                var building_select = $('#BuildingID').get(0);
            }
            var building_id = building_select.selectedOptions.item(0).value;

            console.log(building_id);
            console.log(building_rooms[building_id]);
            var rooms = building_rooms[building_id];

            var room_select = $('#RoomID').get(0);
            while (room_select.options.length > 0) {
                room_select.remove(room_select.options.length - 1);
            }

            for (i = 0; i < rooms.length; i++) {
                var opt = document.createElement('option');

                opt.text = rooms[i];
                opt.value = rooms[i];
                 if (rooms[i] == room_id) {
                     opt.selected = true;
                 }

                room_select.add(opt, null);
            }

        });

        function setRoomId(id) {
            var building_select = $('#BuildingIDNumber').get(0); // TODO: examin other building/room
            var building_id = building_select.selectedOptions.item(0).value;

            console.log(building_id);
            console.log(building_rooms[building_id]);
            var rooms = building_rooms[building_id];

            var room_select = $('#RoomID').get(0);
            while (room_select.options.length > 0) {
                room_select.remove(room_select.options.length - 1);
            }

            for (i = 0; i < rooms.length; i++) {
                var opt = document.createElement('option');

                opt.text = rooms[i];
                opt.value = rooms[i];

                room_select.add(opt, null);
            }
        }

        function buildingChange(o) {
            var building_rooms = [];
            <?php
            echo "\n";
            foreach ($building_rooms as $building_key => $rooms) {
                echo "building_rooms[\"$building_key\"]= [";
                foreach ($rooms as $room) {
                    echo "\"$room\", ";
                }
                echo "];\n";
            }
            ?>
            var building_id = o.value;

            console.log(building_id);
            console.log(building_rooms[building_id]);
            var rooms = building_rooms[building_id];

            var room_select = $('#RoomID').get(0);
            while (room_select.options.length > 0) {
                room_select.remove(room_select.options.length - 1);
            }

            for (i = 0; i < rooms.length; i++) {
                var opt = document.createElement('option');

                opt.text = rooms[i];
                opt.value = rooms[i];

                room_select.add(opt, null);
            }
        }
    </script>
        <?php
    
    return array($building_field, $room_field);
}