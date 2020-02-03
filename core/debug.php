<?php
class Debug {
    public static function log($value){
        echo '<pre>' . print_r($value, true) . '</pre>';
    }
}