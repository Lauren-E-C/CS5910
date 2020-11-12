<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/init.php';

class Form
{
    protected $method = "post";

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function __construct()
    {

    }

    public function showForm($fields = array())
    { // TODO: add other input types
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            foreach ($fields as $index => $values) {
                if (gettype($values) != 'array') {
                    $values = array($index => $values);
                }
                foreach ($values as $key => $value) {
                    $data[$key] = $_POST[$key];
                }
            }
        }
        ?>
        <div class="container">
            <form action="?update" method="post">
                <?php foreach ($fields as $index => $values) { ?>
                    <div class="row">
                        <?php
                        if (gettype($values) != 'array') {
                            $values = array($index => $values);
                        }
                        foreach ($values as $key => $value) {
                            ?>
                            <div class="col-sm form-group">
                                <label for="<?= $key ?>>"><?= $value ?></label>
                                <input type="text" class="form-control" id="<?= $key ?>" name="<?= $key ?>"
                                       placeholder="<?= $value ?>"
                                    <?php if (isset($data[$key])) echo "value=\"$data[$key]\""; ?>
                                >
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <input type="submit" class="btn btn-primary" value="Submit">
            </form>
        </div>
        <?php
        return (count($data) == 0) ? null : $data;
    }
}



class FormField {
    protected $label;
}

class TextField extends FormField {

}
