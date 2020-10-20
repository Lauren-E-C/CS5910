<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class TableNameGrid extends Grid
{
    public function __construct()
    {
        $this->model = new TableName();
        $this->columns = [
            "column_1" => "Column One"
        ];
        try {
            parent::__construct();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}

class SystemUsersGrid extends Grid
{
    public function __construct()
    {
        $this->model = new SystemUsers();
        $this->columns = [
            "IDNumber" => "ID",
            "UEmail" => "E-Mail",
            'FName' => "First Name"
        ];
        try {
            parent::__construct();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}


class Grid
{
    protected $model;
    protected $columns = false;
    protected $filters = false;

    public function __construct()
    {
        $fields = $this->model->getFields();

        if ($this->columns) {
            foreach ($this->columns as $key => $value) {
                if (array_search($key, $fields, true) === false) {
                    throw new Exception("Column name not in table: $key");
                }
            }
        } else {
            foreach ($fields as $field) {
                $this->columns[$field] = $field;
            }
        }
    }

    public function showGrid()
    {
        $m = $this->model;
        ?>
        <div class="container">
            <table class="table table-hover">
                <thead>
                <tr>
                    <?php foreach ($this->columns as $key => $value) {
                        echo "<th>$value</th>\n";
                    } ?>
                </tr>
                </thead>
                <tbody>
                <?php for ($r = $m->get(["IDNumber" => 2]); $r; $r = $m->next()) {
                    $getVars="";
                    foreach ($m->getKeyFields() as $key => $value) {
                        if ($getVars !== "") {
                            $getVars .= "?";
                        }
                        $getVars .= $key . "=" . htmlspecialchars($value);
                    }
                    echo "<tr onclick=\"document.location = 'links.html?".$getVars."';\">";
                    foreach ($this->columns as $key => $value) {
                        echo "<td>$r[$key]</td>\n";
                    }
                    echo "</tr>\n";
                } ?>
                </tbody>
            </table>
        </div>

        <?php
    }
}