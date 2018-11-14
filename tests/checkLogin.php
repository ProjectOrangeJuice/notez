<?php
include("../sys/functions.php");
include("../sys/connection.php");
ini_set('display_errors', 1);
sec_session_start(); // Our custom secure way of starting a PHP session.

if(login_check($conn)){
  echo "You're logged in";
}else{
  echo "You're not logged in";
}


 ?>
