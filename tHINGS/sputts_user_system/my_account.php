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

function getRandomString($length = 16) {
    $validCharacters = "1234567890abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
}

function file_extension($filename)
{
    return end(explode(".", $filename));
}

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
    
    $user = $_SESSION['user'];
    
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
                <form action='my_account.php' method='POST' enctype='multipart/form-data'>
                    <font size='2' face='arial'><b></br>Change avatar: </b></font></br><input type='file' name='myimage'> <input type='submit' name='submit' value='Upload'>
                </form>
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
                        <td width='50px'><a href='change_bio.php'>Edit</a></td>
                    </tr>
                    <tr>
                        <td><div align='right'>Website:</div></td>
                        <td><a href='$website'>$website</a></td>
                        <td width='50px'><a href='change_website.php'>Edit</a></td>
                    </tr>
                    <tr>
                        <td><div align='right'>Country:</div></td>
                        <td>$country</td>
                        <td width='50px'><a href='change_country.php'>Edit</a></td>
                    </tr>
                    <tr>
                        <td><div align='right'>City:</div></td>
                        <td>$city</td>
                        <td width='50px'><a href='change_city.php'>Edit</a></td>
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
    
    echo "
        
    ";
    
    if (isset($_POST['submit'])) {
        $img_name = $_FILES['myimage']['name'];
        $tmp_name = $_FILES['myimage']['tmp_name'];
        $img_size = $_FILES['myimage']['size'];
        
        if ($img_name) {
            
            if ($img_size>2097152) {
                die('Max image size is 2mb!');
            } else {
                $file_ext = file_extension($img_name);
                
                if ($file_ext=='jpeg'||$file_ext=='jpg'||$file_ext=='gif'||$file_ext=='png'||$file_ext=='bmp') {
                    $new_name = getRandomString();
                    $location = "avatars/$new_name";
                    move_uploaded_file($tmp_name,$location.".".$file_ext);
                    
                    mysql_query("UPDATE users SET disp_pic = 'avatars/$new_name.$file_ext' WHERE username = '$user'");
                    
                    header ("location: my_account.php");
                    
                } else {
                    die("Invalid image type!</br></br>Valid images are:</br>
                    <ul>
                    <li>.jpeg</li>
                    <li>.jpg</li>
                    <li>.gif</li>
                    <li>.png</li>
                    <li>.bmp</li>
                    </ul>
                ");
             }   
            }
            
        } else {
            die ("Please select an image!");
        }
    }
    
    echo "</center>";
    
} else {
    header ('location: login.php');
}

?>


