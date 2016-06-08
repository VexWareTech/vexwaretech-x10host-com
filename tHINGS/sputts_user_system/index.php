<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    echo "<center><h1><font face='arial'>Welcome, $user!</h1></br>
    <a href='my_account.php'>My Account</a></br>
    <a href='browse_users.php'>Browse Members</a></br></br>
    <a href='logout.php'>Logout</a></br>
    </font></center>
    ";
    
} else {
    echo "<center><h1><font face='arial'>Welcome, guest! - <a href='login.php'>Login</a></font></h1></center>";
}

?>

