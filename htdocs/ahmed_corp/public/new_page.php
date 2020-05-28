<?php require_once("../includes/start_session.php"); ?> <!-- Start Session and Session Functions -->
<?php require_once("../includes/db_connection.php"); ?> <!-- Connect to Database -->  
<?php require_once("../includes/functions.php"); ?>  <!-- Table of Functions -->
<?php require_once("../includes/validation_functions.php"); ?>  <!-- Table of Validation Functions -->

<?php find_selected_page (); ?>

<?php
    if (!$_GET["subject"]) {  // if i don't have a subject i can't add a page
        redirect_to("manage_content.php");
    }
    global $errors;
    if (isset($_POST) && $_POST != NULL) {
        $subject_id = (int) $_POST["subject_id"];
        $menu_name = input_prepare($_POST["page_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];
        $content = input_prepare($_POST["content"]);

        if (isset($_POST["submit"])) {
            $present = array ("menu_name" => $menu_name, "position" => $position, "visible" => $visible, "content" => $content);
            is_present($present);
            $max_len = array("menu_name" => 30);
            max_length($present, $max_len);
            if (empty($errors)) {
                $query = "INSERT INTO pages ";
                $query .= "(subject_id, menu_name, position, visible, content) ";
                $query .= "VALUES ($subject_id, '{$menu_name}', $position, $visible, '{$content}') ";
                
                $result = mysqli_query($connection, $query);

                if ($result) {
                    $_SESSION["message"] = "Page Created!";
                    redirect_to("manage_content.php?subject={$subject_id}");
                }
                else {
                    $_SESSION["message"] = "Page Creation Failed!";
                    redirect_to("new_page.php?subject={$subject_id}");
                }
            }
            else {
                $_SESSION["errors"] = $errors;
                redirect_to("new_page.php?subject={$subject_id}");
            }    
        }
        else {
            echo "submit button not pressed !";
        }
    }
?>

<?php include("../includes/layout/header.php"); ?> <!-- Html Header --> 


<div id="main">
    <div id="sidebar">
        <a href="admin.php">&laquo; Main Menu</a>
        <?php echo navigation ($subject_id, $page_id); ?>
    </div>
    <div id="container">
        <?php echo message(); ?>
        <?php echo display_validation_errors(); ?>
        <h2>Create Page</h2>
        <form id="new_subject" action="new_page.php?subject=<?php echo urlencode($subject_id); ?>" method="post">
            <input type="hidden" name="subject_id" value="<?php echo $_GET["subject"]; ?>" />
            <label>Menu Name :
                <input type="text" name="page_name" value="" />
            </label>
            <label>Position :
                <select name="position">
                    <?php 
                        $pages = find_pages_in_subject ("pages", $_GET["subject"]);
                        $num_of_pages = count($pages);
                        for ($count=1; $count<=($num_of_pages+1); $count++) {
                            echo "<option value=\"{$count}\"";
                            if ($count == ($num_of_pages+1)) {
                                echo "selected";
                            }
                            echo ">{$count}</option>";
                        }
                    ?>
                </select>
            </label>
            <label>visible :
                <input type="radio" name="visible" value="1" checked />Yes
                <input type="radio" name="visible" value="0" />No
            </label>
            <label>Content :
                <textarea rows="10" cols="90" name="content"></textarea>
            </label>
            <input type="submit" name="submit" value="create page" /><br />
        </form>
        <a id="cancel" href="manage_content.php">Cancel</a>
    </div>
</div>


<?php include("../includes/layout/footer.php"); ?> <!-- Html Footer --> 
<?php require_once("../includes/db_close.php"); ?> <!-- Close Connect to Database --> 