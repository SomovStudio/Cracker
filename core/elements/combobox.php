<?php

class ComboBox {

    private $content = '';

    function __construct($name, $label, $placeholder, $form_action, $submit_value, $data_values, $value_default) {

        $this->content = "<div id='combobox-panel'>";
        $this->content .= "<form action='" . $form_action . "' method='post'>";
        $this->content .= "<label for='" . $name . "'>" . $label . "</label>";
        $this->content .= "<select name='" . $name . "' id='" . $name . "' placeholder='" . $placeholder . "'>";
        foreach ($data_values as $key => $value) {
            if ($value['key'] == $value_default) {
                $this->content .= "<option value='" . $value['key'] . "' selected>".$value['value']."</option>";
            } else {
                $this->content .= "<option value='" . $value['key'] . "'>".$value['value']."</option>";
            }
        }
        $this->content .= "</select>";
        $this->content .= "<input type='submit' value='" . $submit_value . "' class='button-combobox'>";
        $this->content .= "</form>";
        $this->content .= "</div>";
    }

    public function addHiddenInput($name, $value) {
        $this->content = substr($this->content, 0, strlen($this->content)-13);
        $this->content .= "<input name='".$name."' value='".$value."' type='hidden'>";
        $this->content .= "</form>";
        $this->content .= "</div>";
    }

    public function render() {
        echo $this->content;
    }

    public function getContent() {
        return $this->content;
    }
}