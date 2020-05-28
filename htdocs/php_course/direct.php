<?php
    //////////////////////////// 1 db connection ///////////////////////////////
    $host = "localhost";
    $user = "widget_cms";
    $pass = "secretpassword";
    $db_name = "widget_corp";
    $connection = mysqli_connect($host,$user ,$pass ,$db_name );
    if(mysqli_connect_errno()){
        die("database connection failed: " . mysqli_connect_error() . " ( " . mysqli_connect_errno() . " )");
    }
    //////////////////////////////////////////////////////////////////////////

    /////////////////////////// 2 db updatw data ////////////////////////////////
    $up = "UPDATE subjects SET ";
    $up .= "id=4, menu_name='ahmed', position=2, visible=1 ";
    $up .= "WHERE id=4";

    $resu = mysqli_query($connection, $up);

    if ($resu){
        echo " update successfully";
    }
    else {
        die("upadte unsuccessful" . mysqli_error($connection));
    }
    //////////////////////////////////////////////////////////////////////////

    // /////////////////////////// 2 db raed data ////////////////////////////////
    $query = "SELECT * ";
    $query .= "FROM subjects ";
    $query .= "WHERE visible=1 ";
    $query .= "ORDER BY id ASC";
    
    $result = mysqli_query($connection, $query);
    
    if(!$result){
        die("connection error");
    }
    // //////////////////////////////////////////////////////////////////////////

    /////////////////////////// 2 db insert data ////////////////////////////////
    // $menu_name = "ahmed";
    // $position = 1;
    // $visible = 1;

    // $query = "INSERT INTO subjects ";
    // $query .= "(menu_name, position, visible) ";
    // $query .= "VALUES ";
    // $query .= "('{$menu_name}', '{$position}', '{$visible}')";

    // $result = mysqli_query($connection, $query);

    // if($result){
    //    echo "data sent successfully";
    // }
    // else {
    //     die("data not sent successfully " . mysqli_error($connection));
    // }

    // $q = "SELECT * FROM subjects";
    // $r = mysqli_query($connection, $q);
    //////////////////////////////////////////////////////////////////////////

    /////////////////////////// 2 db delete data ////////////////////////////////
    // $d = "DELETE FROM subjects ";
    // $d .= "WHERE id >= 33";

    // $re = mysqli_query($connection, $d);
    
    // if ($re) {
    //     echo "data deleted successfully";
    // }
    // else {
    //     die("data not deleted successfully" . mysqli_error($connection));
    // }
    //////////////////////////////////////////////////////////////////////////

    

    session_start();
    if(isset($_POST["logout"])) {
        $_SESSION = null;
        echo "loged out successfully";
    }
    else {
        echo "<h1 style='text-align:center'>welcome ".htmlentities($_SESSION["username"])."!</h1><p>your password is: ".htmlentities($_SESSION["password"])."</p>";
    }
?>
<html>
    <head>
    
    </head>
    <body>
        <form action="direct.php" method="post">
            <input type="submit" name="logout" value="logout" />
        </form>

        <ul>
        <?php
        /////////////////////////// 3 db use return data ////////////////////////////////
            while($row=mysqli_fetch_assoc($result)){
        ?>
               <li><?php echo $row['menu_name'] . " (" . $row['id'] . ")"; ?></li> 
        <?php
            }
        ////////////////////////////////////////////////////////////////////////////////
        ?>
        </ul>
        <?php
        //////////////////////////// 4 release return data //////////////////////////////
            mysqli_free_result($result);
        ///////////////////////////////////////////////////////////////////////////////
        ?>
    </body>
</html>

<?php
//////////////////////////////// 5 close connection /////////////////////////////////////
    mysqli_close($connection);
///////////////////////////////////////////////////////////////////////////////////////
?>