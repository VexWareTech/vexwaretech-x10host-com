<style type="text/css">

table {
table-layout:fixed;
width:500px;
overflow:hidden;
border:1px solid #f00;
word-wrap:break-word;
}

</style>

<?php

session_start();

function birthday ($birthday)
  {
    list($year,$month,$day) = explode("-",$birthday);
    $year_diff  = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff   = date("d") - $day;
    if ($month_diff < 0) $year_diff--;
    elseif (($month_diff==0) && ($day_diff < 0)) $year_diff--;
    return $year_diff;
  }

if (isset($_SESSION['user'])) {
    
    echo "<center>
    <b><font size='3' face='arial'><a href='index.php'>Return to index page</a></font></b></br><hr>
    <font size='3' face='arial'>
    <b>Current avatar:</b></br>
    </font>
    ";
    
    $user = $_GET['user'];
    
    require ("connect.php");
    
    $result = mysql_query("SELECT * FROM users WHERE username='$user'");
        
        while($row = mysql_fetch_array($result))
            {   
                if ($row['disp_pic']!=null) {
                    $img = $row['disp_pic'];
                    echo "<img src='$img' height='130' width='140'>";
                } else {
                    echo "<img src='avatars/no_image.png'>";
                }
                
                $username = $row['username'];
                $email = $row['email'];
                $dob = $row['dob'];
                $bio = $row['bio'];
                $website = $row['website'];
                $country = $row['country'];
                $city = $row['city'];
                $age = birthday("$dob");
                $last_login = $row['last_login'];
                $joined = $row['joined'];
                
                
                echo "</br>
                <hr>
                <font size='3' face='arial'>
                <table border='0'>
                    <tr>
                        <td><div align='right'>User:</div></td>
                        <td>$username</td>
                    </tr>
                    <tr>
                        <td><div align='right'>E-Mail:</div></td>
                        <td>$email</td>
                    </tr>
                    <tr>
                        <td><div align='right'>Date of Birth:</div></td>
                        <td>$dob</td>
                    </tr>
                    <tr>
                        <td><div align='right'>Age:</div></td>
                        <td>$age</td>
                    </tr>
                    <tr>
                        <td><div align='right'>About yourself (bio):</div></td>
                        <td>$bio</td>
                    </tr>
                    <tr>
                        <td><div align='right'>Website:</div></td>
                        <td><a href='$website'>$website</a></td>
                    </tr>
                    <tr>
                        <td><div align='right'>Country:</div></td>
                        <td>$country</td>
                    </tr>
                    <tr>
                        <td><div align='right'>City:</div></td>
                        <td>$city</td>
                    </tr>
                    <tr>
                        <td><div align='right'>Last Sign-in:</div></td>
                        <td>$last_login</td>
                    </tr>
                    <tr>
                        <td><div align='right'>Date Joined:</div></td>
                        <td>$joined</td>
                    </tr>
                </table>
                </font>
                ";
                
            }
    
    echo "</center>";
    
} else {
    header ('location: login.php');
}

?>