<?php
ini_set('display_errors', 1);
require_once '../connection.php';


$j = json_decode($_POST["nav"]);

foreach($j as $item){

//these are toplevel

  $stmt = "UPDATE public SET parent=0,visable=1 WHERE pageId=:id";
  $q = $conn->prepare($stmt);
  $id = $item->id;
  $q->execute(array(":id"=>$id));

  if(isset($item->children)){

  replaceParent($item->children,$item->id);
}
}
$stmt = "UPDATE public SET visable=0 WHERE location='HIDDEN'";
$q = $conn->prepare($stmt);
$q->execute();
echo "finished";




function replaceParent($items,$parent){
require '../connection.php';


  foreach($items as $it){

    $stmt2 = "UPDATE public SET parent=:par,visable=1 WHERE pageId=:id";

    $q2 = $conn->prepare($stmt2);

    $q2->execute(array(":id"=>$it->id,"par"=>$parent));

    replaceParent($it->children,$it->id);

  }



}




 ?>
