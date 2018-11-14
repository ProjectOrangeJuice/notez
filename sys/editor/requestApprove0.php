<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn)){

$page = $_POST["page"];
if(isset($page)){

          $se = "UPDATE page SET approved=4 WHERE pageId=:page AND userId=:user";
          $stmt = $conn->prepare($se);
          $stmt->bindParam(":page",$page);
          $stmt->bindParam(":user",$_SESSION["user_id"]);
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
