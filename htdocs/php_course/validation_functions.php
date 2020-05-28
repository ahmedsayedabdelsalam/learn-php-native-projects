<?php
    function redirect_to ($location) {
        header("Location: {$location}");
        exit;
    }
    function has_presence($value){
        return isset($value) && $value!="";
    }
    function has_max_length($value, $max){
        return strlen($value) <= $max;
    }
    function error_ul($val){
        $li = "";
        echo "<ul>please check these errors";
        foreach($val as $var){
            $li.= "<li>{$var}</li>";
        }
        return $li;
        echo "</ul>";
    }
?>