<?php

session_start();

if (isset($_SESSION['user'])) {
    header ('location: index.php');
} else {
    
    if ($_POST['username']&&$_POST['password']) {
        
        $posted_username = $_POST['username'];
        $posted_password = $_POST['password'];
        $md5_posted_password = md5($posted_password);
        
        require('connect.php');
        
        $valid_user = 0;
        
        $result = mysql_query("SELECT * FROM users WHERE username='$posted_username' AND password='$md5_posted_password'");
        
        while($row = mysql_fetch_array($result))
            {
                echo "Login Valid!</br></br>Please Wait....";
                $valid = 1;
                $last_login_str = date('Y-m-d');
                mysql_query("UPDATE users SET last_login = '$last_login_str' WHERE username = '$posted_username'");
                $_SESSION['user']=$_POST['username'];
                header ('location: index.php');
            }
            
        if ($valid_user==0) {
            echo "Invalid username and/or password";
        }

        mysql_close($con);
        
    } else {
        echo "Both username and password are required.";
    }
    
}

?>