<?php

session_start();

if (isset($_SESSION['user'])) {
    
    // Code to run if user is logged in already
    header ('location: index.php');
    
} else {
    
    echo "
    <center>
    <form action='proc_login.php' method='POST'>
    <table border='0'>
        <tr>
            <td><div align='right'><font size='2' face='arial'>Username:</font></div></td>
            <td><input type='text' name='username'></td>
        </tr>
        <tr>
            <td><div align='right'><font size='2' face='arial'>Password:</font></div></td>
            <td><input type='password' name='password'></td>
        </tr>
        <tr>
            <td></td>
            <td><div align='right'><font size='2' face='arial'><a href='register.php'>Register</a> - </font><input type='submit' value='Login'></div></td>
        </tr>
    </table>
    </form>
    </center>
    ";
    
}

?>