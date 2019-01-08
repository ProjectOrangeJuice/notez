<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';



$username = $_POST["username"];
$password = $_POST["password"];

if(!isset($username,$password)){
  echo "Not set";
}else if(strlen($password) < 2){
  echo "Error in password";
}else{

    if(!checkBrute($_SERVER['REMOTE_ADDR'], $conn)){

  $se = "SELECT username FROM login WHERE username=:user";
  $stmt = $conn->prepare($se);
  $stmt->bindParam(":user",$username);
  $stmt->execute();
  $row =$stmt->fetchObject();
if($row){
  echo "Username used";
}else{

//add to database
  $password =  password_hash($password, PASSWORD_BCRYPT);
  $se = "INSERT INTO login(username,password) VALUES (:user,:pass)";
  $stmt = $conn->prepare($se);
  $stmt->bindParam(":user",$username);
  $stmt->bindParam(":pass",$password);
  $stmt->execute();
  insertBrute($_SERVER['REMOTE_ADDR'],$conn);
    echo "Registered";


}

}
}else{
  echo "Oops you've been limited";
}



 ?>
