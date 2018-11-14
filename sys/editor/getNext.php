<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
$skip = $_POST["skip"];
if(!isset($_POST["skip"])){
  $skip =  0;
}





sec_session_start();

if (login_check($conn) == true && $_SESSION["user_id"]==1) {

  $se = "SELECT content,description,pageId FROM page WHERE approved=4";

  $stmt = $conn->prepare($se);

  $stmt->execute();
$rows = $stmt->fetchAll();
if($rows[$skip]){
  echo json_encode($rows[$skip]);
  }
else{
//don't send an error.
}



}







 ?>
