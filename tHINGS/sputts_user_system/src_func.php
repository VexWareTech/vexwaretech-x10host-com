<?php

require ('connect.php');

function search_r($search_string) {
    $r_results = array();
    $where = "";
    
    $search_string = preg_split('/[\s]+/', $search_string);
    $total_s_string = count($search_string);
    
    foreach($search_string as $src=>$search) {
        $where .= "`username` LIKE '%$search%'";
        if ($src != ($total_s_string - 1)) {
            $where .= " AND ";
            
        }
    }
    
    $results = "SELECT `username`, `email`, LEFT(`bio`, 50) as `bio`, `disp_pic`, `gender` FROM `users` WHERE $where";
    $results_num = ($results = mysql_query($results)) ? mysql_num_rows($results) : 0;
    
    if ($results_num === 0) {
        return false;
    } else {
        
        while ($results_row = mysql_fetch_assoc($results)) {
            $returned_results[] = array(
                    'username' => $results_row['username'],
                    'disp_pic' => $results_row['disp_pic'],
                    'gender' => $results_row['gender'],
                    'email' => $results_row['email'],
                    'bio' => $results_row['bio']
            );
        }
        
        return $returned_results;
        
    }
}

?>