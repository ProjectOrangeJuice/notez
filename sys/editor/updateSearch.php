<?php



ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn) && $_SESSION["user_id"]==1){

$page = $_POST["page"];
 ?>
