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

  $se = "SELECT page.content,page.description,page.pageId,public.location,public.title FROM page,copied,public WHERE approved=4 AND copied.pageId=page.pageId
   AND public.publicId = copied.publicId";

  $stmt = $conn->prepare($se);

  $stmt->execute();
$rows = $stmt->fetchAll();
if(!$rows){

    $se = "SELECT page.content,page.description,page.pageId FROM page WHERE approved=4 ";

    $stmt = $conn->prepare($se);

    $stmt->execute();
  $rows = $stmt->fetchAll();
}

if($rows[$skip]){
  echo json_encode($rows[$skip]);
  }
else{
//don't send an error.
}



}







 ?>
