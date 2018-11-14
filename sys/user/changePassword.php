<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn)){

$password = $_POST["password"];
$new = $_POST["new"];
if(isset($password,$new)){

  $stmt = $conn->prepare("SELECT userId, username, password
      FROM login
     WHERE userId = :user
      LIMIT 1");
      $stmt->bindParam(':user', $_SESSION["user_id"]);  // Bind "$username" to parameter.
      $stmt->execute();    // Execute the prepared query.
      $row =$stmt->fetch();
      if($row){
        $db_password = $row["password"];
        if (password_verify($password, $db_password)) {

          $password =  password_hash($new, PASSWORD_BCRYPT);
          $se = "UPDATE login SET password=:pass WHERE userId=:user";
          $stmt = $conn->prepare($se);
          $stmt->bindParam(":user",$_SESSION["user_id"]);
          $stmt->bindParam(":pass",$password);
          $stmt->execute();
          echo "Password updated";

        }else{
          echo "Failed password check";
        }
      }else{
        echo "Unable to find user";
      }



}else{
  echo "Invalid input";
}


}else{
  echo "You're not logged in";
}


 ?>
