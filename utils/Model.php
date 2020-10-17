<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Model
{
    protected $table;
    protected $primaryKey;
    private $db;
    private $values;

    public function __construct($table, $primaryKey)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->db = new Database();
    }

    public function getValues() {
        return $this->values;
    }

    public function setValues($values) {
        $this->values = $values;
    }

    public function getValue($index) {
        return $this->values[$index];
    }

    public function setValue($index, $value) {
        $this->values[$index] = $value;
    }

    public function get($primaryKey)
    {
        $clause = $this->makeClause($primaryKey);
        $sql = "select * from {$this->table} where " . $clause;
        var_dump($sql);
        echo "<br>\n";
        $stmt = $this->db->prepare($sql);
        $this->db->exec($stmt);

        echo "<h2>Rows:</h2>";
        $this->values = $this->db->fetchAll($stmt);
        var_dump($this->values);
    }

    private function makeClause($value)
    {
        if (gettype($this->primaryKey) === "array") {
            $return = "";

            for ($i = 0; $i < count($this->primaryKey); $i++) {
                if ($i > 0) {
                    $return = " and " . $return;
                }
                $return = $this->primaryKey[$i] . " = '" . $this->keyValue($value[$i]) . "'";
            }
            return $return;
        }
        else {
            return $this->primaryKey . " = '" . $this->keyValue($value) . "'";
        }
    }

    private function keyValue($value)
    {
        if (gettype($value) === "string") {
            return "'" . $this->db->quote($value) . "'";
        }
        return $value;
    }
}