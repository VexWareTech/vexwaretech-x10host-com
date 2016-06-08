<?php

session_start();

if (isset($_SESSION['user'])) {
    
    unset($_SESSION['user']);
    echo "Logged out!</br></br>Stand by....";
    header ('location: index.php');
    
} else {
    header ('location: index.php');
}

?>