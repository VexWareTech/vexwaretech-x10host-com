<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    require ("connect.php");
    
    $result = mysql_query("SELECT * FROM users WHERE username='$user'");
        
        while($row = mysql_fetch_array($result))
            {
                $get_city = $row['city'];
            }
            
    echo "<center><div align='center'><font size='3' face='arial'>
    
    <form action='proc_change_city.php' method='POST'>
        <table border='0'>
            <tr>
                <td><b>Change City:</b></td>
            </tr>
            <tr>
                <td><input type='text' size='60' name='city' value='$get_city'></td>
            </tr>
            <tr>
                <td><div align='right'><a href='my_account.php'>Cancel</a><input type='submit' value='Change City'></div></td>
            </tr>
        </table>
    </form>
    
    </font></div></center>";
    
} else {
    header ("location: login.php");
}

?>