<?php 
    require_once("validation_functions.php");
    $err = False;
    if (isset($_POST["submit"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $vars = array("username" => $username, "password" => $password);
        $max_len = array("username" => 30, "password" => 8);
        $errors = array();
        $msg = "";
        foreach($vars as $key => $value){
            if (!has_presence($value)) {
                $errors[] = "{$key} is blank ";
            }
        }
        foreach($max_len as $key => $value){
            if (!has_max_length($vars[$key], $value)) {
                $errors[] = "{$key} is max ";
            }
        }
        if (empty($errors)){
            if ($username == "ahmed" && $password == "12345") {
                session_start();
                $_SESSION = array("username" => $username, "password" => $password);
                redirect_to("direct.php");
            }
            else {
                $msg = "username and password don't match";
            }
        }
        else {
            $err = true;
            $msg = "please Try in";
        }
    }
    else {
        $msg = "please log in";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF_8" />
        <title>Try PHP</title>
    </head>
    <body>
        <?php echo"Sign In! <br />"; ?>
        <?php echo $msg; ?>
        <form action="index.php" method="post">
            User Name:<input type="text" name="username" value="" autocomplete="off"/> <br />
            User Name:<input type="password" name="password" value="" /> <br />
            <br />
            <input type="submit" name="submit" value="Submit" />
        </form>
        <?php 
            if ($err){
                echo error_ul($errors);
            }
        ?>
    </body>
</html>