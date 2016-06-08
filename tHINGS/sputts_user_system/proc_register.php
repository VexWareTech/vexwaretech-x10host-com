<?php

session_start();

function getRandomString($length = 9) {
    $validCharacters = "1234567890abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
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
 
//echo birthday("1995-08-12");

if (isset($_SESSION['user'])) {
    
    header ("location: index.php");
    
} else {
    
    if (isset($_POST['r_username'])&&isset($_POST['r_password'])&&isset($_POST['r_password_repeat'])&&isset($_POST['r_email_name'])&&isset($_POST['r_email_service'])&&isset($_POST['r_email_suffix'])&&isset($_POST['r_dob_year'])&&isset($_POST['r_dob_month'])&&isset($_POST['r_dob_day'])&&isset($_POST['r_gender'])&&isset($_POST['r_country'])) {
        
        $got_error = 0;
        
        $username = mysql_real_escape_string(htmlentities(trim($_POST['r_username'])));
        $password = $_POST['r_password'];
        $password_repeat = $_POST['r_password_repeat'];
        $email_name = mysql_real_escape_string(htmlentities(trim($_POST['r_email_name'])));
        $email_service = mysql_real_escape_string(htmlentities(trim($_POST['r_email_service'])));
        $email_suffix = mysql_real_escape_string(htmlentities(trim($_POST['r_email_suffix'])));
        $dob_year = mysql_real_escape_string(htmlentities(trim($_POST['r_dob_year'])));
        $dob_month = mysql_real_escape_string(htmlentities(trim($_POST['r_dob_month'])));
        $dob_day = mysql_real_escape_string(htmlentities(trim($_POST['r_dob_day'])));
        $gender = mysql_real_escape_string(htmlentities(trim($_POST['r_gender'])));
        $country = mysql_real_escape_string(htmlentities(trim($_POST['r_country'])));
        
        $age = birthday("$dob_year-$dob_month-$dob_day");
        
        if (strlen($username)>25) {
            $got_error = 1;
            echo "Username lenght limit exceeded!</br>";
        }
        if (strlen($username)<4) {
            $got_error = 1;
            echo "Username lenght must be 4 characters long or more!</br>";
        }
        if (strlen($password)>25||strlen($password_repeat)>25) {
            $got_error = 1;
            echo "Password lenght limit exceeded!</br>";
        }
        if (strlen($password)<4) {
            $got_error = 1;
            echo "Password must be longer than 4 characters!</br>";
        }
        if ($password!=$password_repeat) {
            $got_error = 1;
            echo "Passwords didn't match!</br>";
        }
        if ($age<13) {
            $got_error = 1;
            $_SESSION['age_submitted']=1;
            echo "You are not old enought to join this site. Sorry!</br>";
        }
        if (strlen($email_name)>25||strlen($email_service)>20||strlen($email_suffix)>3) {
            $got_error = 1;
            echo "One or more of the email boxes exceeded their characters limit!</br>";
        }
        
        if ($got_error==0) {
            $password_md5 = md5($password);
            $build_email = $email_name."@".$email_service.".".$email_suffix;
            $build_dob = $dob_year."-".$dob_month."-".$dob_day;
            $rnd_string = getRandomString();
            $joined = date('Y-m-d');
            
            require ('connect.php');
            
            $used = 0;
            
            $result = mysql_query("SELECT * FROM users WHERE (username='$username') OR (email='$build_email')");
        
            while($row = mysql_fetch_array($result))
            {
                $used = 1;
            }
            
            if ($used==1) {
                die('Username and/or email has already been taken!');
            } else {
                mysql_query("INSERT INTO users (username, password, email, dob, gender, activated, activate_id, joined, country, disp_pic) VALUES ('$username', '$password_md5', '$build_email', '$build_dob', '$gender', '1', '$rnd_string', '$joined', '$country', 'avatars/no_image.png')");
                echo "Thank you for registering! <a href='index.php'>Return to homepage</a>";
            }
            
            
            /*
            //error_reporting(E_ALL);
            error_reporting(E_STRICT);

            date_default_timezone_set('America/Toronto');
            
            
            require_once('class.phpmailer.php');
            //include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

            $mail             = new PHPMailer();

            $body             = file_get_contents('contents.html');
            $body             = eregi_replace("[\]",'',$body);

            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->Host       = "smtp.gmail.com"; // SMTP server
            $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->Host       = "smtp.gmail.com"; // sets the SMTP server
            $mail->Port       = 26;                    // set the SMTP port for the GMAIL server
            $mail->Username   = "djzorrow@gmail.com"; // SMTP account username
            $mail->Password   = "";        // SMTP account password
            
            $to = $build_email;
            $mail->AddReplyTo('djzorrow@gmail.com', 'XaveIt Admin');
            $mail->Subject = "Welcome to XaveIt!";
            $body = "Hi there! </br></br>Welcome to XaveIt! We hope you will enjoy our service. We also hope you play along with the rules! </br></br>Click the link below to activate your account: </br><a href='http://localhost/activate.php?activation_id=$rnd_string'>http://localhost/activate.php?activation_id=$rnd_string</a>";
            $mail->MsgHTML($body);
            $mail->SetFrom ('djzorrow@gmail.com', 'XaveIt Admin');
            $address = $build_email;
            $mail->AddAddress($address, $username);
            
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                
                mysql_query("INSERT INTO users (username, password, email, dob, activated, activate_id, joined, country) VALUES ('$username', '$password_md5', '$build_email', '$build_dob', '0', '$rnd_string', '$country')");
            
                echo "Thank you for registering! An email with account activation instructions has been dispatched to the provided adress. <a href='index.php'>Return to homepage</a>";
            }
            */
        }
        
    } else {
        die("All fields are required!");
    } 
}

?>