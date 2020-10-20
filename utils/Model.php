<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Model implements ModelInterface
{
    protected $table;
    protected $keyFields;
    private $db;
    private $statement = null;
    private $values = null;
    private $keyValues = null;
    private $fields;
    private $fieldList;

    public function __construct($table, $keyFields)
    {
        $this->table = $table;
        if (gettype($keyFields) === "string") {
            $this->keyFields = array($keyFields);
        } else {
            $this->keyFields = $keyFields;
        }
        $this->db = new Database();

        $stmt = $this->db->prepare("DESCRIBE $table");
        $this->db->exec($stmt);
        $this->fields = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $this->fieldList = "";
        foreach ($this->fields as $i => $name) {
            if ($i > 0) {
                $this->fieldList = $this->fieldList . ", ";
            }
            $this->fieldList .= $name;
        }
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setValues($keyValues)
    {
        $first = $this->getFirstElement($keyValues);
        if (gettype($first) === "string") {
            $keyValues = array($keyValues);
        }

        foreach ($keyValues as $keyValue) {
            foreach ($keyValue as $key => $value) {
                $this->setValue($key, $value);
            }
        }
    }

    public function getValue($index)
    {
        return $this->values[$index];
    }

    public function setValue($index, $value)
    {
        if (array_search($index, $this->fields, true)  === false) {
            throw new Exception("Column name not in table: $index");
        }
        $this->values[$index] = $value;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getKeyFields() {
        return $this->keyValues;
    }

    public function get($keyValues = false)
    {
        $sql = "SELECT {$this->fieldList} FROM {$this->table}";

        if ($keyValues) {
            $clause = $this->makeClause($keyValues);
            $sql .= " WHERE " . $clause;
        }
        $this->statement = $this->db->prepare($sql);
        $this->db->exec($this->statement);
        $row = $this->db->fetch($this->statement);

        if ($row === false) {
            return false;
        }

        $this->values = $row;
        // save the fetched key values for updates
        foreach ($this->keyFields as $i => $name) {
            $this->keyValues[$name] = $this->values[$name];
        }

        return $this->values;
    }

    public function next()
    {
        if ($this->statement === null) {
            return null;
        }

        $row = $this->db->fetch($this->statement);

        if ($row === false) {
            return false;
        }

        $this->values = $row;
        // save the fetched key values for updates
        foreach ($this->keyFields as $i => $name) {
            $this->keyValues[$name] = $this->values[$name];
        }

        return $this->values;
    }

    public function update($values = false)
    {
        if ($this->keyValues === null) {
            throw new Exception("Trying to update before get or create");
        }

        if ($values) {
            $this->setValues($values);
        }

        if ($this->values === null) {
            throw new Exception("Values not set for update");
        }

        $set = "SET ";
        foreach ($this->fields as $i => $name) {
            if ($i > 0) {
                $set = ", " . $set;
            }
            $set .= $name . "=" . $this->quoteValue($this->values[$name]);
        }

        $clause = $this->makeClause($this->keyValues);
        $sql = "UPDATE {$this->table} " . $set . " WHERE " . $clause;
        var_dump($sql);
        $stmt = $this->db->prepare($sql)->execute();

        foreach ($this->keyFields as $i => $name) {
            $this->keyValues[$name] = $this->values[$name];
        }
    }

    public function create($values = false)
    {
        if ($values) {
            $this->setValues($values);
        }

        if ($this->values === null) {
            throw new Exception("Values not set for create");
        }

        $fields = "";
        $values = "";
        foreach ($this->fields as $i => $name) {
            if ($i > 0) {
                $fields = ", " . $fields;
                $values = ", " . $values;
            }
            $fields .= $name;
            $values .= $this->quoteValue($this->values[$name]);

        }

        $sql = "INSERT INTO {$this->table}($fields) VALUES ($values)";
        $stmt = $this->db->prepare($sql)->execute();

        // save the key values for updates
        foreach ($this->keyFields as $i => $name) {
            $this->keyValues[$name] = $this->values[$name];
        }
    }

    private function makeClause($keyValues)
    {
        $return = "";

        $first = $this->getFirstElement($keyValues);
        if (gettype($first) === "string") {
            $keyValues = array($keyValues);
        }

        foreach ($keyValues as $keyValue) {
            foreach ($keyValue as $key => $value) {

                if (array_search($key, $this->fields, true)  === false) {
                    throw new Exception("Column name not in table: $key");
                }

                if ($return !== "") {
                    $return = " AND " . $return;
                }
                if (gettype($value) === "array") {
                    $return .= $key . " BETWEEN " . $this->quoteValue($value[0]) . " AND " . $this->quoteValue($value[1]);
                } else {
                    $return .= $key . " = " . $this->quoteValue($value);
                }
            }
        }
        return $return;
    }

    private function quoteValue($value)
    {
        if (gettype($value) === "string") {
            return "'" . $this->db->quote($value) . "'";
        }
        return $value;
    }

    private function getFirstElement($array)
    {
        foreach ($array as $key => $value) {
            return $key;
        }
        return null;
    }
}