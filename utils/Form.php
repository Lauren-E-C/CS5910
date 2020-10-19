<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class TableNameForm extends Form
{
    public function __construct()
    {
        $this->model = new TableName();
        $this->fields = [
            "column_1" => "Field One"
        ];
        try {
            parent::__construct();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}


class Form
{
    protected $model;
    protected $fields = false;
    protected $filters = false;

    public function __construct()
    {
        $fields = $this->model->getFields();

        if ($this->fields) {
            foreach ($this->fields as $key => $value) {
                if (array_search($key, $fields, true) === false) {
                    throw new Exception("Column name not in table: $key");
                }
            }
        } else {
            foreach ($fields as $field) {
                $this->fields[$field] = $field;
            }
        }
    }

    public function showForm()
    {
        $m = $this->model;
        $primaryKey = array();
        echo "hi";
        print_r($m->getKeyFields());
        print_r(":");
        foreach ($m->getKeyFields() as $key => $value) {
            print_r($key);
            $primaryKey[$key] = $_GET[$key];
        }
        $r = $m->get($primaryKey);
        print_r($primaryKey);
        print_r($r);

        ?>
        <form>
            <?php foreach ($this->fields as $key => $value) { ?>
            <div class="form-group">
                <label for="<?= $key ?>>"><?= $value ?></label>
                <input type="email" class="form-control" id="<?= $key ?>" placeholder="<?= $value ?>" value="<?= $r[$key] ?>">
            </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

<!--        <div class="container">-->
<!--            <table class="table table-hover">-->
<!--                <thead>-->
<!--                <tr>-->
<!--                    --><?php //foreach ($this->fields as $key => $value) {
//                        echo "<th>$value</th>\n";
//                    } ?>
<!--                </tr>-->
<!--                </thead>-->
<!--                <tbody>-->
<!--                --><?php //for ($r = $m->get(["column_1" => [0, 999]]); $r; $r = $m->next()) {
//                    $getVars="";
//
//                    echo "<tr onclick=\"document.location = 'links.html?".$getVars."';\">";
//                    foreach ($this->fields as $key => $value) {
//                        echo "<td>$r[$key]</td>\n";
//                    }
//                    echo "</tr>\n";
//                } ?>
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->

        <?php
    }
}