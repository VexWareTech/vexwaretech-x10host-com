<?php

session_start();

if (isset($_SESSION['user'])) {
    
    echo "<center>
    
    <b><font size='3' face='arial'><a href='index.php'>Return to index page</a></font></b></br><hr>
    
    <form action='src_users.php' method='POST'>
        <input type='text' name='search_string'> <input type='submit' value='Search Users'>
    </form><hr>
    
    ";
    
    if (isset($_POST['search_string'])) {
    
    include ("src_func.php");
    
    $search_string = mysql_real_escape_string(htmlentities(trim($_POST['search_string'])));
    
    $errors = array();
    
    if (empty($search_string)) {
        $errors[] = 'Your search cant be empty!';
    } else if (strlen($search_string)<2){
        $errors[] = 'Your search must have atleast 2 characters!';
    } else if (search_r($search_string) === false) {
        $errors[] = 'Your search returned no results!';
    }
    
    if (empty($errors)) {
        
        $results = search_r($search_string);
        $results_num = count($results);
        
        echo "<table border='0'>";
        foreach($results as $result) {
            
            $v_username = $result['username'];
            $v_disp_pic = $result['disp_pic'];
            $v_gender = $result['gender'];
            $v_bio = $result['bio'];
            
            echo "
            <tr>
                <td><img src='http://localhost/s/$v_disp_pic' height='70' width='70'></td>
                <td><font size='2' face='arial'><a href='view_user.php?user=$v_username'>$v_username</a></br>Gender: <i>$v_gender</i></br>About myself: <i>$v_bio</i></font></td>
            </tr>
            ";
        }
        echo "</table>";
        
    } else {
        foreach($errors as $error) {
            echo "$error </br>";
        }
        
    }
    
    }
    
    echo "</center>";
    
} else {
    header ("location: login.php");
}

?>