<?php

$skip = $_POST["skip"];
if(!isset($_POST["skip"])){
  $skip =  0;
}



include_once 'db_connect.php';
include_once 'connection.php';
include_once 'functions.php';

sec_session_start();

if (login_check($mysqli) == true) {

  $se = "SELECT page FROM waiting";

  $stmt = $conn->prepare($se);

  $stmt->execute();
$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

if($result[$skip]){

  $se = "SELECT information,summary,content,editKey FROM userPages WHERE editKey=:key ORDER BY userPages.id DESC";
  $stmt = $conn->prepare($se);
  $stmt->bindParam(":key",$result[$skip]["page"]);

  $stmt->execute();


  $row =$stmt->fetchObject();

echo json_encode($row);

}

}else{
//don't send an error.
}











 ?>
