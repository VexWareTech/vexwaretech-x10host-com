<?php

$acti_id = $_GET['activation_id'];
$valid = 0;

require ('connect.php');
$result = mysql_query("SELECT * FROM users WHERE activation_id='$acti_id' AND activated='0'");
        
    while($row = mysql_fetch_array($result))
        {
            $valid = 1;
            mysql_query("UPDATE users SET activated = '1' WHERE activation_id = '$acti_id'");
        }
        
    if ($valid==0) {
        die ("The activation id is either wrong or the account is already activated!");
    }

?>