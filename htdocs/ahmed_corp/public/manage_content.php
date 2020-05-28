<?php require_once("../includes/start_session.php"); ?> <!-- Start Session and Session Functions -->
<?php require_once("../includes/db_connection.php"); ?> <!-- Connect to Database -->  
<?php require_once("../includes/functions.php"); ?>  <!-- Table of Functions -->


<?php include("../includes/layout/header.php"); ?> <!-- Html Header --> 
<?php find_selected_page (); ?>


<div id="main">
    <div id="sidebar">
        <a href="admin.php">&laquo; Main Menu</a>
        <?php echo navigation ($subject_id, $page_id); ?>
        <a href="new_subject.php">+ Add a Subject</a>
    </div>
    <div id="container">
        <?php echo message(); ?>
        <div><?php echo page($subject_id, $page_id);?></div>
    </div>
</div>


<?php include("../includes/layout/footer.php"); ?> <!-- Html Footer --> 
<?php require_once("../includes/db_close.php"); ?> <!-- Close Connect to Database --> 