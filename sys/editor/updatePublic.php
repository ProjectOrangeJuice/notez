<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn) && $_SESSION["user_id"]==1){

$loc = $_POST["location"];
$value = $_POST["value"];
if(isset($page,$value)){



          $se = "UPDATE public SET pageId=:value WHERE location=:page";
          $stmt = $conn->prepare($se);
          $stmt->bindParam(":value",$value);
          $stmt->bindParam(":page",$loc);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count==0){
            echo "Didn't update";
          }else{
            echo "Updated";
          }





}else{
  echo "Invalid input";
}


}else{
  echo "You're not logged in";
}


 ?>
