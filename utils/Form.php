<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Form
{
    protected $method = "post";
    private $data = null;
    private $disabled = false;

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param bool $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    public function __construct($method = "post")
    {
        $this->method = $method;
    }

    public function getValues($keys)
    {
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            foreach ($keys as $key) {
                if (isset($_POST[$key])) {
                    $data[$key] = $_POST[$key];
                }
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            foreach ($keys as $key) {
                if (isset($_GET[$key])) {
                    $data[$key] = $_GET[$key];
                }
            }
        }
        return (count($data) == 0) ? null : $data;
    }

    public function setValues($data)
    {
        $this->data = $data;
    }

    public function showForm($fields = array())
    {

        $data = array();
        if ($this->data) {
            $data = $this->data;
        } else {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                foreach ($fields as $index => $values) {
                    if (gettype($values) != 'array') {
                        $values = array($index => $values);
                    }
                    foreach ($values as $key => $value) {
                        if (!isset($_POST[$key])) throw new Exception("Key $key not in _POST");
                        $data[$key] = $_POST[$key];
                    }
                }
            }
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                foreach ($fields as $index => $values) {
                    if (gettype($values) != 'array') {
                        $values = array($index => $values);
                    }
                    foreach ($values as $key => $value) {
                        if (isset($_GET[$key])) {
                            $data[$key] = $_GET[$key];
                        }
                    }
                }
            }
        }
        ?>
        <div class="container">
            <form action="?save" method="<?= $this->method ?>">
                <fieldset
                    <?php
                    if ($this->disabled == true)
                        echo " disabled=\"disabled\" ";
                    ?>
                >
                    <?php foreach ($fields as $index => $values) { ?>
                        <div class="row">
                            <?php
                            if (gettype($values) != 'array') {
                                $values = array($index => $values);
                            }
                            foreach ($values as $key => $value) {
                                $this->fields[] = $key;
                                if (gettype($value) == "object") {
                                    $value->generate($data, $key);
                                    continue;
                                } else {
                                    $tf = new TextField($value);
                                    $tf->generate($data, $key);
                                }
                            } ?>
                        </div>
                    <?php } ?>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </fieldset>
            </form>
        </div>
        <?php
        return (count($data) == 0) ? null : $data;
    }
}


abstract class FormField
{
    protected $label;
    protected $default_value = null;

    public function __construct($label = false)
    {
        if ($label) {
            $this->setLabel($label);
        }
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function setValue($value)
    {
        $this->default_value = $value;
    }

    abstract function generate($data, $key);
}

class TextField extends FormField
{
    function generate($data, $key)
    { ?>
        <div class="col-sm form-group">
            <label for="<?= $key ?>"><?= $this->label ?></label>
            <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>"
                   placeholder="<?= $this->label ?>"
                <?php if (isset($data[$key])) echo "value=\"$data[$key]\""; ?>
            >
        </div>
    <?php }
}
class TextAreaField extends FormField
{
    function generate($data, $key)
    { ?>
        <div class="col-sm form-group">
            <label for="<?= $key ?>"><?= $this->label ?></label>
            <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>"
                   placeholder="<?= $this->label ?>"
                <?php if (isset($data[$key])) echo "value=\"$data[$key]\""; ?>
            >
        </div>
    <?php }
}
class ReadOnlyField extends FormField
{
    function generate($data, $key)
    { ?>
        <div class="col-sm form-group">
            <label for="<?= $key ?>"><?= $this->label ?></label>
            <input type="text" readonly="readonly" class="form-control" id="<?= $key ?>" name="<?= $key ?>"
                   placeholder="<?= $this->label ?>"
                <?php if (isset($data[$key])) echo "value=\"$data[$key]\""; ?>
            >
        </div>
    <?php }
}

class HiddenField extends FormField
{
    protected $data = null;

    public function __construct($label = false, $data = false)
    {
        if ($data) {
            $this->data = $data;
        }
        parent::__construct($label);
    }

    function generate($data, $key)
    { ?>
        <input type="hidden" class="form-control" id="<?= $key ?>" name="<?= $key ?>" value="<?= $this->data ?>">
    <?php }
}

class DateField extends FormField
{
    function generate($data, $key)
    {
        if (!isset($data[$key]) && $this->default_value !== null) {
            $data[$key] = $this->default_value;
        }
        ?>
        <div class="col-sm form-group">
            <label for="<?= $key ?>"><?= $this->label ?></label>
            <input type="date" class="form-control" id="<?= $key ?>" name="<?= $key ?>"
                   placeholder="<?= $this->label ?>"
                <?php if (isset($data[$key])) echo "value=\"$data[$key]\""; ?>
            >
        </div>
    <?php }
}

class SelectField extends FormField
{
    protected $values = array();

    public function __construct($label = false, $values = false)
    {
        if ($values) {
            $this->values = $values;
        }
        parent::__construct($label);
    }

    function generate($data, $key)
    {
        $v = "";
        if (isset($data[$key])) {
            $v = $data[$key];
        } ?>
        <div class="col-sm form-group">
            <label for="<?= $key ?>"><?= $this->label ?></label>
            <select class="combobox custom-select" id="<?= $key ?>" name="<?= $key ?>">
                <?php foreach ($this->values as $value) { ?>
                    <option <?php if ($v && $v == $value) echo "selected " ?>
                            value="<?= $value ?>"><?= $value ?></option>
                <?php } ?>
            </select>
        </div>

    <?php }
}

class KeyValueField extends FormField
{
    protected $values = array();

    public function __construct($label = false, $values = false)
    {
        if ($values) {
            $this->values = $values;
        }
        parent::__construct($label);
    }

    function generate($data, $index)
    {
        $k = "";
        if (isset($data[$index])) {
            $k = $data[$index];
        } ?>
        <div class="col-sm form-group">
            <label for="<?= $index ?>"><?= $this->label ?></label>
            <select class="custom-select" id="<?= $index ?>" name="<?= $index ?>">
                <?php foreach ($this->values as $key => $value) { ?>
                    <option <?php if ($k && $k == $key) echo "selected " ?>
                            value="<?= $key ?>"><?= $value ?></option>
                <?php } ?>
            </select>
        </div>

    <?php }
}