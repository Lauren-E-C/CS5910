<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

//class SectionGrid extends Grid
//{
//    public function __construct()
//    {
//        $this->model = new Section();
//        $this->columns = [
//            "CourseRegistrationNumber" => "Course Registration Number",
//            "SectionNumber" => "Section Number",
//            'CourseID' => "CourseID",
//            'SeatsCapacity' => "Seats",
//            'RoomID' => "Room",
//            'BuildingName' => "Building"
//        ];
//        try {
//            parent::__construct();
//        } catch (Exception $e) {
//            throw new Exception($e);
//        }
//    }
//}

class Grid
{
    protected $model;
    protected $onclickPage = null;
    protected $columns = false;
    protected $filters = false;

    public function __construct($model, $columns = false)
    {
        $this->model = $model;
        if ($columns) {
            $this->columns = $columns;
        }

        $fields = $this->model->getFields();

        if ($this->columns) {
            foreach ($this->columns as $key => $value) {
                if (substr($key,0,1) != ':' && array_search($key, $fields, true) === false) {
                    throw new Exception("Column name not in table: |{$key}|");
                }
            }
        } else {
            foreach ($fields as $field) {
                $this->columns[$field] = $field;
            }
        }
    }

    public function setOnclickPage($onclickPage) {
        $this->onclickPage = $onclickPage;
    }

    public function showGrid($filter = false)
    {
        $m = $this->model;
        ?>
        <div class="container-fluid">

            <table class="table table-hover">
                <thead>
                <tr>
                    <?php foreach ($this->columns as $key => $value) {
                        if (is_array($value)) {
                            echo "<th>$value[0]</th>\n";
                        } else {
                            echo "<th>$value</th>\n";
                        }
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php for ($r = $m->get($filter); $r; $r = $m->next()) {
                    $getVars = "";
                    foreach ($m->getKeyFields() as $key => $value) {
                        if ($getVars !== "") {
                            $getVars .= "&";
                        }
                        $getVars .= $key . "=" . htmlspecialchars($value);
                    }
                    if ($this->onclickPage) {
                        echo "<tr onclick=\"document.location = '".$this->onclickPage."?" . $getVars . "';\">";
                    } else {
                        echo "<tr>";
                    }
                    foreach ($this->columns as $key => $value) {
                        echo "<td>";
                        if (is_array($value)) {
                            // ['Student ID', 'Student', 'lastName'],
                            echo $m->getValue($value[2], $value[1]);
                        } else {
                            echo $m->getValue($key);
                        }
                        echo "</td>";
                    }
                    echo "</tr>\n";
                } ?>
                </tbody>
            </table>
        </div>

        <?php
    }
}