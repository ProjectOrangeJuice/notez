<?php
ini_set('display_errors', 1);

include_once '../connection.php';
include_once '../functions.php';
sec_session_start();


if(!login_check($conn)){
  echo "You're not logged in";
}else{

$page = $_POST["page"];

//check they own page

    $stmt = $conn->prepare("SELECT content
        FROM page
        WHERE pageId = :page AND userId=:user");
        $stmt->bindParam(':page', $page);  // Bind "$username" to parameter.
        $stmt->bindParam(":user",$_SESSION["user_id"]);
        $stmt->execute();    // Execute the prepared query.
        $row =$stmt->fetch();
        if($row){
        $se = "INSERT INTO removed(pageId) VALUES (:page)";
        $stmt = $conn->prepare($se);
        $stmt->bindParam(":page",$page);

        $stmt->execute();

        }else{
          echo "Page can't be accessed";
        }



}



 ?>
