<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    $new_city = $_POST['city'];
    
    require ("connect.php");
    
    mysql_query("UPDATE users SET city = '$new_city' WHERE username = '$user'");
    
    echo "Your city location has been updated!</br>Redirecting....";
    
    header("location: my_account.php");
    
} else {
    header("location: login.php");
}

?>