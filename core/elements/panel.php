<?php

class Panel {

    private $content = '';

    function __construct() {
        $this->content = "<div id='panel-elements'>";
        $this->content .= "<table style=\"height: 30px;\">";
        $this->content .= "<tr>";
    }

    public function addContent($content) {
    	//$this->content .= "<li>".$content."</li>";
        $this->content .= "<td>".$content."</td>";
    }

    public function render() {
    	$this->content .= "</tr>";
        $this->content .= "</table>";
    	$this->content .= "</div>";
        echo $this->content;
    }

}
