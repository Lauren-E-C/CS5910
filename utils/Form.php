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
        foreach ($m->getKeyFields() as $key => $value) {
            $primaryKey[$key] = $_GET[$key];
        }
        $r = $m->get($primaryKey);
        ?>
        <form>
            <?php foreach ($this->fields as $key => $value) { ?>
            <div class="form-group">
                <label for="<?= $key ?>>"><?= $value ?></label>
                <input type="text" class="form-control" id="<?= $key ?>" placeholder="<?= $value ?>" value="<?= $r[$key] ?>">
            </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <?php
    }
}