<?php
ini_set('display_errors', 1);

include_once '../connection.php';
include_once '../functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.
if (isset($_POST['username'], $_POST['password'])) {
   file_put_contents('logs.txt', "aBout to login"."\n" , FILE_APPEND );
    $username = $_POST['username'];
    $password = $_POST['password']; // The hashed password.
    if(!checkBrute($_SERVER['REMOTE_ADDR'], $conn)){
    if (login($username, $password, $conn) == true) {
        // Login success
        echo "True";
    } else {
        // Login failed
        insertBrute($_SERVER['REMOTE_ADDR'],$conn);
        echo "False";
    }
  }else{
    echo "Oops, you've been locked out";
  }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}
?>
