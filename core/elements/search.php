<?php

class Search {

    private $content = '';

    function __construct($form_action, $input_placeholder, $submit_value) {
        $this->content = "<div id='search-panel'>";
        $this->content .= "<form action='" . $form_action . "' method='post'>";
        $this->content .= "<input name='event' value='search' type='hidden'>";
        $this->content .= "<input type='text' name='search' id='search' placeholder='" . $input_placeholder . "'>";
        $this->content .= "<input type='submit' value='" . $submit_value . "' class='button-search'>";
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