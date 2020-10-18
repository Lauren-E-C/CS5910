<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/utils/init.php';

class TableNameGrid extends Grid {

    public function __constructor()
    {
        $this->model = new TableName();
        $columns = [
          "column_1" => "Column One"
        ];
        parent::__constructor();
    }
}


class Grid
{
    protected $model;
    protected $columns = false;
    protected $filters = false;

    public function __constructor() {
        $fields = $this->model->getFields();

        if ($this->columns) {
            foreach ($this->columns as $key => $value) {
                if (array_search($key, $fields, true)  === false) {
                    throw new Exception("Column name not in table: $key");
                }
            }
        } else {
            foreach ($fields as $field) {
                $this->columns[$field] = $field;
            }
        }
    }
}