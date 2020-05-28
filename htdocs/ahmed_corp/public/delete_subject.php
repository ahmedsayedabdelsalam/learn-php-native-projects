<?php
    require_once("../includes/start_session.php"); // Start Session and Session Functions  
    require_once("../includes/db_connection.php"); // Connect to Database  
    require_once("../includes/functions.php"); // Table of Functions
   
    $subject = find_item_by_id ("subjects", $_GET["subject"]);
    $no_of_pages = mysqli_num_rows (find_pages_for_subject($subject["id"]));
    if (isset($subject)) {
        if ($no_of_pages >0 ){
            $_SESSION["message"] = "Subject Contains More Than One Page in it Please Delete Them First";
            redirect_to("edit_subject.php?subject={$subject['id']}");
        }
        else {
            $query = "DELETE FROM subjects WHERE id={$subject["id"]}";
            $result = mysqli_query($connection, $query);
            if ($result && mysqli_affected_rows($connection)) {
                $_SESSION["message"] = "Subject Deleted!";
                redirect_to("manage_content.php");
            }
            else {
                $_SESSION["message"] = "Subject Deletion Failed!";
                redirect_to("edit_subject.php?subject={$subject['id']}");
            }
        }
    }
    

    require_once("../includes/db_close.php"); // Close Connect to Database
?>