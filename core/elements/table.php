<?php

class Table {

    private $content = '';
    private $columns = '';
    private $width = 0;
    private $height = 0;
    private $columnArray;
    private $hiddenInputs = "";

    const TYPE_COLUMN = 'type_column';
    const TYPE_NUMBER_COLUMN = 'type_number_column';
    const TYPE_BUTTON_EDIT = 'type_button_edit';
    const TYPE_BUTTON_DELETE = 'type_button_delete';
    const TYPE_BUTTON_STEPS = 'type_button_steps';
    const EVENT_EDIT = 'edit';
    const EVENT_DELETE = 'delete';
    const EVENT_STEPS = 'steps';

    function __construct($height) {
        $this->height = $height;
        $this->content = "<div id='table'>";
    }

    private function getPath($parameters, $row) {
        $path = "";
        foreach ($parameters as $key => $value) {
            if ($path !== "")
                $path .= "&";
            $path .= $value . "=" . $row[$value];
        }
        return $path;
    }

    private function getParams($parameters, $row) {
        $params = '';
        foreach ($parameters as $key => $value) {
            $params .= "<input name='" . $value . "' value='" . $row[$value] . "' type='hidden'>";
        }
        return $params;
    }

    public function addColunm($name, $title, $size) {
        $this->width += $size;
        $this->columns .= "<th style='width: " . $size . "px'>" . $title . "</th>";
        $this->columnArray[$name] = array('type' => self::TYPE_COLUMN, 'title' => $title, 'size' => $size);
    }

    public function addNumberColunm($name, $title, $size) {
        $this->width += $size;
        $this->columns .= "<th style='width: " . $size . "px'>" . $title . "</th>";
        $this->columnArray[$name] = array('type' => self::TYPE_NUMBER_COLUMN, 'title' => $title, 'size' => $size);
    }

    public function addButtonEdit($action, $parameters = []) {
        $this->width += 50;
        $this->columns .= "<th class='table-column-edit'>...</th>";
        $this->columnArray['button_edit'] = array('type' => self::TYPE_BUTTON_EDIT, 'action' => $action, 'parameters' => $parameters, 'size' => 50);
    }

    public function addButtonDelete($action, $parameters = []) {
        $this->width += 50;
        $this->columns .= "<th class='table-column-delete'>...</th>";
        $this->columnArray['button_delete'] = array('type' => self::TYPE_BUTTON_DELETE, 'action' => $action, 'parameters' => $parameters, 'size' => 50);
    }

    public function addButtonSteps($action, $parameters = []) {
        $this->width += 50;
        $this->columns .= "<th class='table-column-steps'>...</th>";
        $this->columnArray['button_steps'] = array('type' => self::TYPE_BUTTON_STEPS, 'action' => $action, 'parameters' => $parameters, 'size' => 50);
    }

    public function addHiddenInput($name, $value) {
        $this->hiddenInputs .= "<input name='".$name."' value='".$value."' type='hidden'>";
    }

    public function setData($dataTable) {
        $this->content .= "<table style='width: " . $this->width . "px;'>";
        $this->content .= "<thead>";
        $this->content .= "<tr>";
        $this->content .= $this->columns;
        $this->content .= "</tr>";
        $this->content .= "</thead>";
        $this->content .= "<tbody style='height: " . $this->height . "vh;'>";

        $index = 1;
        mysqli_data_seek($dataTable, 0);
        while ($row = mysqli_fetch_assoc($dataTable)) {
            $this->content .= "<tr>";
            foreach ($this->columnArray as $key => $value) {
                if ($value['type'] == self::TYPE_COLUMN) {
                    $this->content .= "<td style='width: " . $value['size'] . "px;'>" . $row[$key] . "</td>";
                } elseif ($value['type'] == self::TYPE_NUMBER_COLUMN) {
                    $this->content .= "<td style='width: " . $value['size'] . "px;'>" . ($index++) . "</td>";
                } elseif ($value['type'] == self::TYPE_BUTTON_EDIT) {
                    $this->content .= "<td style='width: " . $value['size'] . "px; text-align:center'>";
                    $this->content .= "<form action='" . $value['action'] . "' method='post'>";
                    $this->content .= "<input type='submit' value='' class='table-button-edit'>";
                    $this->content .= "<input name='event' value='".self::EVENT_EDIT."' type='hidden'>";
                    $this->content .= $this->hiddenInputs;
                    $this->content .= $this->getParams($value['parameters'], $row);
                    $this->content .= "</form>";
                    $this->content .= "</td>";
                } elseif ($value['type'] == self::TYPE_BUTTON_DELETE) {
                    $this->content .= "<td style='width: " . $value['size'] . "px; text-align:center'>";
                    $this->content .= "<form action='" . $value['action'] . "' method='post'>";
                    $this->content .= "<input type='submit' value='' class='table-button-delete' onclick='onTableRowDelete()'>";
                    $this->content .= "<input name='event' value='".self::EVENT_DELETE."' type='hidden'>";
                    $this->content .= $this->hiddenInputs;
                    $this->content .= $this->getParams($value['parameters'], $row);
                    $this->content .= "</form>";
                    $this->content .= "</td>";
                } elseif ($value['type'] == self::TYPE_BUTTON_STEPS) {
                    $this->content .= "<td style='width: " . $value['size'] . "px; text-align:center'>";
                    $this->content .= "<form action='" . $value['action'] . "' method='post'>";
                    $this->content .= "<input type='submit' value='' class='table-button-steps'>";
                    $this->content .= "<input name='event' value='".self::EVENT_STEPS."' type='hidden'>";
                    $this->content .= $this->hiddenInputs;
                    $this->content .= $this->getParams($value['parameters'], $row);
                    $this->content .= "</form>";
                    $this->content .= "</td>";
                }
            }
            $this->content .= "</tr>";
        }

        $this->content .= "</tbody>";
        $this->content .= "</table>";
    }

    public function render() {
        /*$this->content .= "</div>";*/
        $this->content .= "</div>";
        echo $this->content;
    }

    public function getContent() {
        return $this->content;
    }
}
