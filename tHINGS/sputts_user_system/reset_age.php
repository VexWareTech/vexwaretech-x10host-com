<?php

session_start();

unset($_SESSION['age_submitted']);
echo "Age submitted has been reset!";

?>