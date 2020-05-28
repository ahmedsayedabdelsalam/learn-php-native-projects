<?php
    require_once("../includes/start_session.php"); // Start Session and Session Functions  
    require_once("../includes/db_connection.php"); // Connect to Database  
    require_once("../includes/functions.php"); // Table of Functions
    require_once("../includes/validation_functions.php"); // Table of Validation Functions
    
    global $errors;
    if (isset($_POST) && $_POST != NULL) {
        $menu_name = input_prepare($_POST["subject_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];

        if (isset($_POST["submit"])) {
            $present = array ("menu_name" => $menu_name, "position" => $position, "visible" => $visible);
            is_present($present);
            $max_len = array("menu_name" => 30);
            max_length($present, $max_len);
            if (empty($errors)) {
                $query = "INSERT INTO subjects ";
                $query .= "(menu_name, position, visible) ";
                $query .= "VALUES ('{$menu_name}', $position, $visible) ";
                
                $result = mysqli_query($connection, $query);

                if ($result) {
                    $_SESSION["message"] = "Subject Created!";
                    redirect_to("manage_content.php");
                }
                else {
                    $_SESSION["message"] = "Subject Creation Failed!";
                    redirect_to("new_subject.php");
                }
            }
            else {
                $_SESSION["errors"] = $errors;
                redirect_to("new_subject.php");
            }    
        }
        else {
            echo "submit button not pressed !";
        }
    }
    else {
        redirect_to("new_subject.php");
    }
    

    require_once("../includes/db_close.php"); // Close Connect to Database
?>