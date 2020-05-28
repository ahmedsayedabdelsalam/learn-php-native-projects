<?php require_once("../includes/start_session.php"); ?> <!-- Start Session and Session Functions -->
<?php require_once("../includes/db_connection.php"); ?> <!-- Connect to Database -->  
<?php require_once("../includes/functions.php"); ?>  <!-- Table of Functions -->

<?php find_selected_page (); ?>

<?php
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
                $query = "UPDATE subjects SET ";
                $query .= "menu_name ='{$menu_name}', ";
                $query .= "position ='{$position}', ";
                $query .= "visible ='{$visible}' ";
                $query .= "WHERE id={$subject_id} ";
                $query .= "LIMIT 1";
                
                $result = mysqli_query($connection, $query);

                if ($result && mysqli_affected_rows($connection) == 1) {
                    $_SESSION["message"] = "Subject Updated!";
                    redirect_to("manage_content.php");
                }
                else {
                    $_SESSION["message"] = "Subject Update Failed! You have to change anything";
                    redirect_to("edit_subject.php?subject={$subject_id}");
                }
            }
            else {
                $_SESSION["errors"] = $errors;
                redirect_to("edit_subject.php?subject={$subject_id}");
            }    
        }
        else {
            echo "submit button not pressed !";
        }
    }
    else {
        // redirect_to("edit_subject.php");
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
        <h2>Edit Subject : <?php echo htmlentities(find_item_by_id('subjects', $subject_id)['menu_name']); ?></h2>
        <form id="new_subject" action="edit_subject.php?subject=<?php echo urlencode($subject_id); ?>" method="post">
            <label>Menu Name :
                <input type="text" name="subject_name" value="<?php echo htmlentities(find_item_by_id('subjects', $subject_id)['menu_name']); ?>" />
            </label>
            <label>Position :
                <select name="position">
                    <?php 
                        $subjects = find_all_subjects();
                        $num_of_subjects = mysqli_num_rows($subjects);
                        for ($count=1; $count<=($num_of_subjects); $count++) {
                            echo "<option value=\"{$count}\"";
                            if ($count == find_item_by_id('subjects', $subject_id)['position']) {
                                echo "selected";
                            }
                            echo ">{$count}</option>";
                        }
                    ?>
                </select>
            </label>
            <label>visible :
                <input type="radio" name="visible" value="1" <?php if(find_item_by_id('subjects', $subject_id)['visible'] == 1) {echo "checked";} ?>/>Yes
                <input type="radio" name="visible" value="0" <?php if(find_item_by_id('subjects', $subject_id)['visible'] == 0) {echo "checked";} ?>/>No
            </label>
            <input type="submit" name="submit" value="edit subject" /><br />
        </form>
        <a id="cancel" href="manage_content.php?subject=<?php echo urlencode($subject_id); ?>">Cancel</a> &nbsp;&nbsp;
        <a id="cancel" href="delete_subject.php?subject=<?php echo urlencode($subject_id); ?>" onclick="return confirm('Are You Sure You Want To Delete!')">Delete Subject</a>
    </div>
</div>


<?php include("../includes/layout/footer.php"); ?> <!-- Html Footer --> 
<?php require_once("../includes/db_close.php"); ?> <!-- Close Connect to Database --> 