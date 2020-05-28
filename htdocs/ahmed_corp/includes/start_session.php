<?php
    session_start();

    function message () {
        if (isset($_SESSION["message"])) {
            $output = "<div class=\"message\">";
            $output .= htmlentities($_SESSION["message"]);
            $output .= "</div>";

            $_SESSION["message"] = NULL;
            
            return $output;
        }
    }

    function display_validation_errors(){ // Display Validation Errors
        if (isset($_SESSION["errors"])  && $_SESSION["errors"]!="") {
            $errors = $_SESSION["errors"];
            echo "<ul class=\"message\"> Validation Errors";
            foreach ($errors as $key => $val) {
                $output = "<li>";
                $output .= htmlentities(ucwords(str_replace("_", " " ,$key)));
                $output .=" : " . htmlentities($val);
                $output .= "</li>" ;
                echo $output;
                $_SESSION["errors"] = NULL;
            }
            echo "</ul>";
        }   
    }
?>