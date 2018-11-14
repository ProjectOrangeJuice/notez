<?php



ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn) && $_SESSION["user_id"]==1){

$page = $_POST["page"];
$value = $_POST["value"];
$title = $_POST["title"];
$sum = $_POST["summary"];
$loc = $_POST["location"];
if(isset($page,$value)){
  if($value==1){
  }else{
    $value = 2;
    $se = "UPDATE page SET approved=:value WHERE pageId=:page";
    $stmt = $conn->prepare($se);
    $stmt->bindParam(":value",$value);
    $stmt->bindParam(":page",$page);
    $stmt->execute();
  }


          $se = "UPDATE page SET approved=:value, title=:title, description=:desc WHERE pageId=:page";
          $stmt = $conn->prepare($se);
          $stmt->bindParam(":value",$value);
          $stmt->bindParam(":title",$title);
          $stmt->bindParam(":desc",$sum);
          $stmt->bindParam(":page",$page);
          $stmt->execute();


          if($value == 1){

            $stmt = $conn->prepare("SELECT publicId
                FROM public
               WHERE location = :loc
                LIMIT 1");
                $stmt->bindParam(':loc', $loc);  // Bind "$username" to parameter.
                $stmt->execute();    // Execute the prepared query.
                $row =$stmt->fetch();


                if ($row) {
                  echo "Public issue +".$row["publicId"];
                }else{

                  $stmt = $conn->prepare("SELECT pageId
                      FROM page
                     WHERE pageId = :loc
                      LIMIT 1");
                      $stmt->bindParam(':loc', $page);  // Bind "$username" to parameter.
                      $stmt->execute();    // Execute the prepared query.
                      $row =$stmt->fetch();

                  $se = "INSERT INTO public(pageId,location,title) VALUES (:page,:loc,:title)";
                  $stmt = $conn->prepare($se);
                  $stmt->bindParam(":page",$row["pageId"]);
                  $stmt->bindParam(":loc",$loc);
                  $stmt->bindParam(":title",$title);
                  $stmt->execute();
                  echo "Approved updated";
                }


          }else{
              echo "Approved updated";
          }




}else{
  echo "Invalid input";
}


}else{
  echo "You're not logged in";
}


 ?>
