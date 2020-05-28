<?php
    require_once("../includes/start_session.php"); // Start Session and Session Functions  
    require_once("../includes/db_connection.php"); // Connect to Database  
    require_once("../includes/functions.php"); // Table of Functions
    
    find_selected_page ();
    
    $page = find_item_by_id ("pages", $_GET["page"]);
    if (isset($page)) {
        $query = "DELETE FROM pages WHERE id={$page["id"]}";
        $result = mysqli_query($connection, $query);
        if ($result && mysqli_affected_rows($connection)) {
            $_SESSION["message"] = "Page Deleted!";
            redirect_to("manage_content.php?subject={$subject_id}");
        }
        else {
            $_SESSION["message"] = "Subject Deletion Failed!";
            redirect_to("edit_subject.php?subject={$subject['id']}");
        }
    }
    

    require_once("../includes/db_close.php"); // Close Connect to Database
?>