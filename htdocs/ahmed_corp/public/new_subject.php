<?php require_once("../includes/start_session.php"); ?> <!-- Start Session and Session Functions -->
<?php require_once("../includes/db_connection.php"); ?> <!-- Connect to Database -->  
<?php require_once("../includes/functions.php"); ?>  <!-- Table of Functions -->

<?php find_selected_page (); ?>

<?php include("../includes/layout/header.php"); ?> <!-- Html Header --> 


<div id="main">
    <div id="sidebar">
        <a href="admin.php">&laquo; Main Menu</a>
        <?php echo navigation ($subject_id, $page_id); ?>
    </div>
    <div id="container">
        <?php echo message(); ?>
        <?php echo display_validation_errors(); ?>
        <h2>Create Subject</h2>
        <form id="new_subject" action="create_subject.php" method="post">
            <label>Menu Name :
                <input type="text" name="subject_name" value="" />
            </label>
            <label>Position :
                <select name="position">
                    <?php 
                        $subjects = find_all_subjects();
                        $num_of_subjects = mysqli_num_rows($subjects);
                        for ($count=1; $count<=($num_of_subjects+1); $count++) {
                            echo "<option value=\"{$count}\"";
                            if ($count == ($num_of_subjects+1)) {
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
            <input type="submit" name="submit" value="create subject" /><br />
        </form>
        <a id="cancel" href="manage_content.php">Cancel</a>
    </div>
</div>


<?php include("../includes/layout/footer.php"); ?> <!-- Html Footer --> 
<?php require_once("../includes/db_close.php"); ?> <!-- Close Connect to Database --> 