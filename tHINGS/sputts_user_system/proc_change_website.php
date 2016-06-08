<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    $new_website_url = $_POST['website_url'];
    
    require ("connect.php");
    
    mysql_query("UPDATE users SET website = '$new_website_url' WHERE username = '$user'");
    
    echo "Your website url has been updated!</br>Redirecting....";
    
    header("location: my_account.php");
    
} else {
    header("location: login.php");
}

?>