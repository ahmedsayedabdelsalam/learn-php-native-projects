<?php // make a connection to database
    define("DB_HOST", "localhost");
    define("DB_USER", "ahmed");
    define("DB_PASS", "ahmedsayed");
    define("DB_NAME", "ahmed_corp");

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // if error print msg [con. error with con. error bla bla (con. error no)]
    if(mysqli_connect_errno()) {
        die("Database Connection Failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }
?>