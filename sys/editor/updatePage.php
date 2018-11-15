<?php
ini_set('display_errors', 1);
include_once '../connection.php';
include_once '../functions.php';
sec_session_start(); // Our custom secure way of starting a PHP session.


if(login_check($conn)){

$loc = $_POST["page"];
$value = $_POST["content"];





if(isset($loc,$value)){


  require_once '../clean/HTMLPurifier.standalone.php';

  $config = HTMLPurifier_Config::createDefault();
  $config->set('URI.Base', 'http://192.168.1.110'); //Allowed url
  $config->set("URI.DisableExternal",true);
  $purifier = new HTMLPurifier($config);
  $clean_html = $purifier->purify($value);
  $dirty = "";
  if($value != $clean_html){
    $dirty = $value;
  }


          $se = "UPDATE page SET content=:value, dirty=:val WHERE pageId=:page AND userId=:user";
          $stmt = $conn->prepare($se);
          $stmt->bindParam(":value",$value);
          $stmt->bindParam(":page",$loc);
          $stmt->bindParam(":val",$dirty);
          $stmt->bindParam(":user",$_SESSION["user_id"]);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count==0){
            echo "Didn't update";
          }else{
            echo "Updated";
          }





}else{
  echo "Invalid input";
}


}else{
  echo "You're not logged in";
}


 ?>
