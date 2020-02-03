<?php
class Form {

    private $content = '';

    function __construct($title, $action, $event, $height) {
        $this->content = "<div id='form' style='height:" .$height. "vh'><h4>" . $title . "</h4><dr>";
        $this->content .= "<form action='" . $action . "' method='post'>";
        $this->content .= "<div id='form-content' style='height:".($height-15)."vh'>";
        $this->content .= "<input name='event' value='" . $event . "' type='hidden'>";
    }

    public function addTextBox($name, $label, $placeholder, $value, $readonly = false) {
        $this->content .= "<br><label for='" . $name . "' class='label'>" . $label . "</label>";
        if ($readonly) {
            $this->content .= "<br><input type='text' name='" . $name . "' id='" . $name . "' placeholder='" . $placeholder . "' class='text-box' disabled value='" . $value . "'>";
            $this->content .= "<br><input name='" . $name . "' value='" . $value . "' type='hidden'>";
        } else {
            $this->content .= "<br><input type='text' name='" . $name . "' id='" . $name . "' placeholder='" . $placeholder . "' class='text-box' value='" . $value . "'><br>";
        }
    }

    public function addPasswordTextBox($name, $label, $placeholder, $value, $readonly = false) {
        $this->content .= "<br><label for='" . $name . "' class='label'>" . $label . "</label>";
        if ($readonly) {
            $this->content .= "<br><input type='password' name='" . $name . "' id='" . $name . "' placeholder='" . $placeholder . "' class='text-box' disabled value='" . $value . "'>";
            $this->content .= "<br><input name='" . $name . "' value='" . $value . "' type='hidden'>";
        } else {
            $this->content .= "<br><input type='password' name='" . $name . "' id='" . $name . "' placeholder='" . $placeholder . "' class='text-box' value='" . $value . "'><br>";
        }
    }

    public function addComboBox($name, $label, $placeholder, $data_values, $value_default) {
        $this->content .= "<br><label for='" . $name . "' class='label'>" . $label . "</label>";
        $this->content .= "<br><select name='" . $name . "' id='" . $name . "' placeholder='" . $placeholder . "' class='combo-box'>";
        foreach ($data_values as $key => $value) {
            if ($value['key'] == $value_default) {
                $this->content .= "<option value='" . $value['key'] . "' selected>".$value['value']."</option>";
            } else {
                $this->content .= "<option value='" . $value['key'] . "'>".$value['value']."</option>";
            }
        }
        $this->content .= "</select><br>";
    }

    public function addMemoBox($name, $label, $placeholder, $value) {
        $this->content .= "<br><label for='" . $name . "' class='label'>" . $label . "</label>";
        $this->content .= "<br><textarea name='" . $name . "' id='" . $name . "' cols='40' rows='30' placeholder='" . $placeholder . "' class='memo-box'>" . $value . "</textarea><br>";
    }

    /*
    public function addButtonSave($value = 'Сохранить') {
        $this->content .= "<br><input type='submit' value='" . $value . "' class='button-save'>";
    }
    */

    public function addHiddenInput($name, $value) {
        $this->content .= "<input name='".$name."' value='".$value."' type='hidden'>";
    }

    public function render() {
        $this->content .= "</div>";
        $this->content .= "<br><input type='submit' value='Сохранить' class='button-save'>";
        $this->content .= "</form>";
        $this->content .= "</div>";
        echo $this->content;
    }

    public function getContent() {
        return $this->content;
    }
}