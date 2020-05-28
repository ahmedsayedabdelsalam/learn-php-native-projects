<?php
 
    $errors = array();

    function is_present($value){
        global $errors;
        foreach ($value as $key => $val) {
            if ($val == "0") {

            }
            elseif (!isset($val) || $val == "") {
                $errors[$key] = "can't be blank";
            }
        }
    }

    function max_length($value, $max_len){
        global $errors;
        foreach ($value as $key => $val) {
            if (!empty($max_len["{$key}"]) && $max_len["{$key}"] != "") {
                if (strlen($val) > $max_len["{$key}"])  {
                $errors[$key] = "is too long";
                }
            } 
        }
    }

?>