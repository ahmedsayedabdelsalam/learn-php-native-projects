<?php
    
    function redirect_to ($new_location){  // Change Direction
        header("Location: " . ($new_location));
        exit;
    }

    function input_prepare ($input) { // Escape Input Code Injection
        global $connection;
        return mysqli_real_escape_string($connection, $input);
    }

    function confirm_query($set_result){ // Confirm Query is Ok
        if (!$set_result) {
            die("Database Query Failed.");
        }
    }

    function find_all_subjects(){ // Perform Database Query From Subjects Table
        global $connection;

        $query = "SELECT * ";
        $query .= "FROM subjects ";
        // $query .= "WHERE visible=1 ";
        $query .= "ORDER BY position ASC";

        $subjects_res = mysqli_query($connection, $query);
        
        confirm_query($subjects_res); // Confirm Query is Ok

        return $subjects_res;
    }
    
    function find_item_by_id ($table, $subject_id) { // Find Item in a Table By its ID
        global $connection;

        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

        $query = "SELECT * ";
        $query .= "FROM {$table} ";
        $query .= "WHERE id={$safe_subject_id} ";
        $query .= "ORDER BY position ASC";

        $subjects_res = mysqli_query($connection, $query);
        
        confirm_query($subjects_res); // Confirm Query is Ok

        if ($subjects = mysqli_fetch_assoc($subjects_res)) {
            return $subjects;
        }
        else {
            return null;
        }  
    }

    function find_pages_in_subject ($table, $subject_id) { // Find Item in a Table By its ID
        global $connection;

        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

        $query = "SELECT * ";
        $query .= "FROM {$table} ";
        $query .= "WHERE subject_id={$safe_subject_id} ";
        $query .= "ORDER BY position ASC";

        $pages_res = mysqli_query($connection, $query);
        
        confirm_query($pages_res); // Confirm Query is Ok

        while ($pages = mysqli_fetch_assoc($pages_res)) {
            $output[] = $pages;
        }
        return $output;
    }

    function find_items_by_subject_id ($table, $subject_id) { // Find Item in a Table By its ID
        global $connection;

        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

        $query = "SELECT * ";
        $query .= "FROM {$table} ";
        $query .= "WHERE subject_id={$safe_subject_id} ";
        $query .= "ORDER BY position ASC";

        $subjects_res = mysqli_query($connection, $query);

        confirm_query($subjects_res); // Confirm Query is Ok

        $output = "<ul>";    
        while ($subjects = mysqli_fetch_assoc($subjects_res)) {
            $output .= "<li><a href='manage_content.php?page={$subjects['id']}'>{$subjects['menu_name']}</a></li>";
        }
        $output .= "</ul>";
        return $output;
    }

    function page ($subject_id, $page_id) { // Write menu name and header
        if ($subject_id) {
            $current_subject = find_item_by_id ("subjects", $subject_id);
            $current_pages = find_items_by_subject_id ("pages", $subject_id); 

            $result = "<h2>Manage Subject</h2>";
            $result .= "<p>Menu Name : ";
            $result .= htmlentities($current_subject["menu_name"]);
            $result .= "</P>";
            $result .= "<p>Position : ";
            $result .= htmlentities($current_subject["position"]);
            $result .= "</P>";
            $result .= "<p>Visible : ";
            $current_subject["visible"] == 1 ? $result .="Yes" : $result .="No" ;
            $result .= "</P>";
            $result .= "<a class='block edit_subject' href='edit_subject.php?subject=";
            $result .= urldecode($subject_id);
            $result .= "'>Edit Subject</a>";
            $result .= "<hr />";
            $result .= "<h3>Pages in this Subject</h3>";
            $result .= $current_pages;
            $result .= "<a class='block edit_subject' href='new_page.php?subject={$current_subject['id']}'>+ Add a new Page to this Subject</a>";

            return $result;
        }
        elseif ($page_id){
            $current_page = find_item_by_id ("pages", $page_id); 
            
            $result = "<h2>Manage Page</h2>";
            $result .= "<p>Menu Name : ";
            $result .= htmlentities($current_page["menu_name"]);
            $result .= "</P>";
            $result .= "<p>Position : ";
            $result .= htmlentities($current_page["position"]);
            $result .= "</P>";
            $result .= "<p>Visible : ";
            $current_page["visible"] == 1 ? $result .="Yes" : $result .="No" ;
            $result .= "</P>";
            $result .= "<div class='text-area'>Content : <p>";
            $result .= htmlentities($current_page["content"]);
            $result .= "</p></div>";
            $result .= "<a class='block edit_subject' href='edit_page.php?subject=";
            $result .= urldecode($current_page["subject_id"]);
            $result .= "&page=";
            $result .= urldecode($page_id);
            $result .= "'>Edit Page</a>";

            return $result;
        }
        else {
            return "Please Select a Subject or a Page !";
        }
    }

    function find_pages_for_subject($subject_id){ // Perform Database Query From pages Table
        global $connection;

        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE visible=1 ";
        $query .= "AND subject_id={$safe_subject_id} ";
        $query .= "ORDER BY position ASC";

        $pages_res = mysqli_query($connection, $query);
        
        confirm_query($pages_res); // Confirm Query is Ok

        return $pages_res;
    }

    function find_selected_page () { // Find Selected Page or Subject ID
        global $subject_id;
        global $page_id;
        
        if(isset($_GET["subject"])){
            $subject_id = $_GET["subject"];
            $page_id = NULL;
        }
        elseif(isset($_GET["page"])) {
            $subject_id = NULL;
            $page_id = $_GET["page"];
        }

        if (isset($_GET["subject"]) && isset($_GET["page"])) {
            $subject_id = $_GET["subject"];
             $page_id = $_GET["page"];
        }
    }

    function navigation ($subject_id, $page_id) { // Admin navigation
        $output = "<ul>";
        // Perform Database Query From Subjects Table
        $subjects_res = find_all_subjects();  
        // Use Returned Data (if any)
        while($subjects=mysqli_fetch_assoc($subjects_res)) { // Output Data From Each Row
            $output .= "<li ";
            if($subject_id == $subjects["id"]) {
                $output .= "class=\"selected\"";
            }  
            $output .= ">";
            $output .= "<a href=\"manage_content.php?subject=";
            $output .= urlencode($subjects["id"]); 
            $output .= "\">";
            $output .= htmlentities($subjects["menu_name"]);
            $output .= "</a>";
            $output .= "<ul>";
            // Perform Database Query From pages Table
            $pages_res = find_pages_for_subject($subjects["id"]);         
            // Use Returned Data (if any)
            while($pages=mysqli_fetch_assoc($pages_res)) { // Output Data From Each Row          
                $output .= "<li ";
                if($page_id == $pages["id"]) {
                    $output .= "class=\"selected\"";
                }
                $output .= ">";
                $output .= "<a href=\"manage_content.php?page=";
                $output .= urlencode($pages["id"]); 
                $output .= "\">";
                $output .= htmlentities($pages["menu_name"]); 
                $output .= "</a>";
                $output .= "</li>";
            } 
            // Release Returned Data From Pages Table
            mysqli_free_result($pages_res);        
            $output .= "</ul>";
            $output .= "</li>";    
        } 
        // Release Returned Data From Subjects Table
        mysqli_free_result($subjects_res); 
        $output .= "</ul> ";
        return $output;       
    }
?>