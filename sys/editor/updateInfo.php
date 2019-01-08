<?php
ini_set('display_errors', 1);

include_once '../connection.php';
include_once '../functions.php';
sec_session_start();


if(!login_check($conn)){
  echo "You're not logged in";
}else{

$desc = htmlspecialchars($_POST["desc"]);
$page = $_POST["page"];

$se = "UPDATE page SET description=:desc WHERE pageId=:page AND userId=:user";
$stmt = $conn->prepare($se);
$stmt->bindParam(":desc",$desc);
$stmt->bindParam(":page",$page);
$stmt->bindParam(":user",$_SESSION["user_id"]);
$stmt->execute();
}



 ?>
