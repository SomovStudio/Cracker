<?php

class Button {

    private $content = '';

    function __construct($form_action, $submit_value, $height, $width) {
        $this->content = "<div id='button-empty'>";
        $this->content .= "<form action='" . $form_action . "' method='post'>";
        $this->content .= "<input type='submit' value='" . $submit_value . "' class='button' style='height:" . $height . "px; width:" . $width . "px;'>";
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