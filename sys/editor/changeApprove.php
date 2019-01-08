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




            if(isset($_POST["force"])){
              update($title,$loc,$page);

            }else{

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

                  $stmt = $conn->prepare("SELECT pageId,content
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
                  $searchVal = $row["content"]." ".$title." ".$loc;
                  updateSearch($loc,$searchVal);
                  echo "Approved updated";
                }
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






function updateSearch($public,$content){
    $content = str_replace( '<', ' <',$content );

    $newContent = strip_tags($content);

    include '../connection.php';
    include_once '../functions.php';
    $stmt = $conn->prepare("UPDATE search SET search=:search WHERE location=:pub");
        $stmt->bindParam(':search', $newContent);  // Bind "$username" to parameter.
        $stmt->bindParam(':pub', $public);  // Bind "$username" to parameter.
        $stmt->execute();
        $count = $stmt->rowCount();

        if($count == 0){
          $stmt = $conn->prepare("INSERT INTO search VALUES (:location,:pub)");
              $stmt->bindParam(':location', $public);  // Bind "$username" to parameter.
              $stmt->bindParam(':pub', $newContent);  // Bind "$username" to parameter.
              $stmt->execute();
        }



}






function update($title,$loc,$page){
  include '../connection.php';
  include_once '../functions.php';
  $stmt = $conn->prepare("UPDATE public SET pageId=:page, title=:title WHERE location=:loc");
      $stmt->bindParam(':page', $page);  // Bind "$username" to parameter.
      $stmt->bindParam(':loc', $loc);  // Bind "$username" to parameter.
      $stmt->bindParam(':title', $title);  // Bind "$username" to parameter.
      $stmt->execute();



      $stmt = $conn->prepare("SELECT pageId,content,title,location
          FROM page,public
         WHERE page.pageId = :loc AND page.pageId = public.pageId
          LIMIT 1");
          $stmt->bindParam(':loc', $page);  // Bind "$username" to parameter.
          $stmt->execute();    // Execute the prepared query.
          $row =$stmt->fetch();
          $searchVal = $row["content"]." ".$row["title"]." ".$row["location"];
          updateSearch($loc,$searchVal);
}
 ?>
