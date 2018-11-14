<?php
require_once __DIR__.'/bootstrap.php';
include_once 'task/db_connect.php';
require_once __DIR__.'/task/connection.php';
include_once 'task/functions.php';
$url = $_SERVER['REQUEST_URI'];
sec_session_start();

$login = login_check($mysqli);




$indexArray = array("/","/index.html","/index.php");

if(in_array($url,$indexArray)){
$template =  $twig->load("index.twig");

$stmt = $conn->query("SELECT * FROM nav WHERE parent='/'");
$naver = array();
while ($row = $stmt->fetch()) {
    array_push($naver, array("subItem"=>"","name"=>$row["title"],"location"=>$row["location"]));
}

echo $template->render(array(
  'sideNavItems' => $naver,
  'login' => $login
));


}else if($url == "/user/editor"){


  $se = "SELECT information,id,summary,editKey FROM userPages WHERE userId=? AND approved=0";
  $stmt = $mysqli->prepare($se);
  $userId = $_SESSION["user_id"];
  $stmt->bind_param("s",$userId);
  $stmt->execute();

  /* bind result variables */
     $stmt->bind_result($info,$pageId, $summary,$key);

     /* fetch values */
     $waiting = array();
     while ($stmt->fetch()) {
       array_push($waiting,array("info"=>$info,"summary"=>$summary,"view"=>$key,"edit"=>$key,"del"=>$pageId));
       }


  $template =  $twig->load("editor.twig");
  echo $template->render(array(
    'login' => true,
    "waitingItems" => $waiting

  ));
}




?>
