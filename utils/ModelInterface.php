<?php

interface ModelInterface
{
    /**
     * @return mixed
     * Returns associative array of record's values
     */
    public function getValues();

    /**
     * @param $keyValues
     * @return void
     * Takes associative array of values
     */
    public function setValues($keyValues);

    /**
     * @param $index
     * @return mixed
     * Returns value of field specified by $index
     */
    public function getValue($index);

    /**
     * @param $index
     * @param $value
     * @return mixed
     * Sets field at $index to to $value
     * Throws Excpetion if $index is not a valid field name
     */
    public function setValue($index, $value);

    /**
     * @return mixed
     * Returns array of all fields in model
     */
    public function getFields();

    /**
     * @return mixed
     * Returns array of fields that are part of primary key
     */
    public function getKeyFields();

    /**
     * @param false $keyValues
     * Associative array keyed on field names with search values.
     * Value my be scalar for exact match, or array of two values for "BETWEEN"
     * @return mixed
     * returns row , or false if not found.
     */
    public function get($keyValues = false);

    /**
     * @return mixed
     * Returns next record after "get" or false if end of rows
     */
    public function next();

    /**
     * @param false $values
     * @return mixed
     * Updates a record that was previously retrieved with  "get" or "created".
     * $values is optional.
     */
    public function update($values = false);

    /**
     * @param false $values
     * @return mixed
     * Inserts a record into underlying table
     */
    public function create($values = false);
}