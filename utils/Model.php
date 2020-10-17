<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Model
{
    protected $table;
    protected $primaryKey;
    private $db;
    private $values;
    private $fields;
    private $fieldList;

    public function __construct($table, $primaryKey)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->db = new Database();

        $stmt = $this->db->prepare("DESCRIBE $table");
        $this->db->exec($stmt);
        $this->fields = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->fieldList = "";
        foreach ($this->fields as $i => $name) {
            if ($i > 0) {
                $this->fieldList = ", " . $this->fieldList;
            }
            $this->fieldList .= $name;
        }
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setValues($values)
    {
        $this->values = $values;
    }

    public function getValue($index)
    {
        return $this->values[$index];
    }

    public function setValue($index, $value)
    {
        $this->values[$index] = $value;
    }

    public function get($primaryKey)
    {
        $clause = $this->makeClause($primaryKey);
        $sql = "select {$this->fieldList} from {$this->table} where " . $clause;

        $stmt = $this->db->prepare($sql);
        $this->db->exec($stmt);

        $this->values = $this->db->fetchAll($stmt);
        // TODO: save original record for updates
    }

    public function update($values = false)
    {
        if ($values) {
            $this->setValues($values);
        }

        $set = "SET ";
        foreach ($this->fields as $i => $name) {
            if ($i > 0) {
                $set = ", " . $set;
            }
            $set .= $name . "=" . $this->quoteValue($this->values[$name]);
        }

        // TODO: compound primary keys
        $sql = "UPDATE {$this->table} " . $set . " WHERE {$this->primaryKey} =  " . $this->quoteValue($this->values[$this->primaryKey]);
        var_dump($sql);
    }

    private function makeClause($value)
    {
        if (gettype($this->primaryKey) === "array") {
            $return = "";

            for ($i = 0; $i < count($this->primaryKey); $i++) {
                if ($i > 0) {
                    $return = " and " . $return;
                }
                $return = $this->primaryKey[$i] . " = '" . $this->quoteValue($value[$i]) . "'";
            }
            return $return;
        } else {
            return $this->primaryKey . " = '" . $this->quoteValue($value) . "'";
        }
    }

    private function quoteValue($value)
    {
        if (gettype($value) === "string") {
            return "'" . $this->db->quote($value) . "'";
        }
        return $value;
    }
}