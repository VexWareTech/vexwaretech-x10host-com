<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    $new_bio_txt = $_POST['bio'];
    
    require ("connect.php");
    
    mysql_query("UPDATE users SET bio = '$new_bio_txt' WHERE username = '$user'");
    
    echo "Your About me text has been updated!</br>Redirecting....";
    
    header("location: my_account.php");
    
} else {
    header("location: login.php");
}

?>