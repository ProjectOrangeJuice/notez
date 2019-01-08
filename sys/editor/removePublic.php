<?php
ini_set('display_errors', 1);

include_once '../connection.php';
include_once '../functions.php';
sec_session_start();


if(!login_check($conn)){
  echo "You're not logged in";
}else{

//check they own page

    $stmt = $conn->prepare("SELECT pageId
        FROM page
        WHERE approved=1 AND userId=:user AND NOT EXISTS (SELECT pageId FROM removed WHERE removed.pageId = page.pageId)");
        $stmt->bindParam(":user",$_SESSION["user_id"]);
        $stmt->execute();    // Execute the prepared query.
        $rows = $stmt->fetchAll();
        foreach($rows as $row) {
          $se = "INSERT INTO removed(pageId) VALUES (:page)";
          $stmt = $conn->prepare($se);
          $stmt->bindParam(":page",$row["pageId"]);

          $stmt->execute();

        }





}



 ?>
