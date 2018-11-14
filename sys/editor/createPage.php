<?php
ini_set('display_errors', 1);

include_once '../connection.php';
include_once '../functions.php';
sec_session_start();


if(!login_check($conn)){
  echo "You're not logged in";
}else{

$desc = $_POST["desc"];

$se = "INSERT INTO page(description,userId) VALUES (:desc,:user)";
$stmt = $conn->prepare($se);
$stmt->bindParam(":desc",$desc);
$stmt->bindParam(":user",$_SESSION["user_id"]);
$stmt->execute();
$last_id = $conn->lastInsertId();
echo $last_id;

}



 ?>
