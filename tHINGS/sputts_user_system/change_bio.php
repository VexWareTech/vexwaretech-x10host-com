<?php

session_start();

if (isset($_SESSION['user'])) {
    
    $user = $_SESSION['user'];
    
    require ("connect.php");
    
    $result = mysql_query("SELECT * FROM users WHERE username='$user'");
        
        while($row = mysql_fetch_array($result))
            {
                $get_bio = $row['bio'];
            }
            
    echo "<center><div align='center'><font size='3' face='arial'>
    
    <form action='proc_change_bio.php' method='POST'>
        <table border='0'>
            <tr>
                <td><b>Edit About me:</b></td>
            </tr>
            <tr>
                <td><textarea name='bio' rows='5' cols='50'>$get_bio</textarea></td>
            </tr>
            <tr>
                <td><div align='right'><a href='my_account.php'>Cancel</a><input type='submit' value='Update About me'></div></td>
            </tr>
        </table>
    </form>
    
    </font></div></center>";
    
} else {
    header ("location: login.php");
}

?>