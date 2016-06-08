<?php

session_start();

if (isset($_SESSION['user'])) {
    
    echo "<center>
    
    <b><font size='3' face='arial'><a href='index.php'>Return to index page</a></font></b></br><hr>
    
    <form action='src_users.php' method='POST'>
        <input type='text' name='search_string'> <input type='submit' value='Search Users'>
    </form><hr>
    <font size='4' face='arial'>10 latest registered users</font></br></br>
    ";
    
    require ("connect.php");
    
    $result = mysql_query("SELECT * FROM users ORDER BY id DESC LIMIT 0, 10");
        
    while($row = mysql_fetch_array($result))
    {
        echo "<table border='0'>";
        $username = $row['username'];
        $disp_pic = $row['disp_pic'];
        $gender = $row['gender'];
        
        echo "
        <tr>
            <td><img src='http://localhost/s/$disp_pic' height='70' width='70'></td>
            <td><font size='2' face='arial'><a href='view_user.php?user=$username'>$username</a></br>Gender: <i>$gender</i></font></td>
        </tr>
        ";
        
        echo "</table>";
    }
    
} else {
    header ("location: login.php");
}

?>