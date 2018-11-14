<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn)){

$page = $_POST["page"];
if(isset($page)){

    $stmt = $conn->prepare("SELECT content
        FROM page
        WHERE pageId = :page");
        $stmt->bindParam(':page', $_POST["page"]);  // Bind "$username" to parameter.

        $stmt->execute();    // Execute the prepared query.
        $row =$stmt->fetch();
        if($row){
          echo $row["content"];
        }else{
          echo "Page can't be accessed";
        }





}else{
  echo "Invalid input";
}


}else{
  echo "You're not logged in";
}


 ?>
