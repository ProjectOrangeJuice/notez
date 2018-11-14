<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn)){

  $stmt = $conn->prepare("SELECT page.pageId,page.description,page.content
      FROM public
      INNER JOIN page on public.pageId=page.pageId
      WHERE public.pageId = :page");
      $stmt->bindParam(':page', $_POST["page"]);  // Bind "$username" to parameter.
      $stmt->execute();    // Execute the prepared query.
      $row =$stmt->fetch();
      if($row){

      $se = "INSERT INTO page(description,content,userId) VALUES (:desc,:content,:user)";
      $stmt = $conn->prepare($se);
      $stmt->bindParam(":desc",$row["description"]);
      $stmt->bindParam(":content",$row["content"]);
      $stmt->bindParam(":user",$_SESSION["user_id"]);
      $stmt->execute();
      $last_id = $conn->lastInsertId();
      echo $last_id;
}else{
  echo "Page can't be copied";
}


}else{
  echo "You're not logged in";
}



 ?>
