<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    $new_country = $_POST['new_country'];
    
    require ("connect.php");
    
    mysql_query("UPDATE users SET country = '$new_country' WHERE username = '$user'");
    
    echo "Your country location has been updated!</br>Redirecting....";
    
    header("location: my_account.php");
    
} else {
    header("location: login.php");
}

?>