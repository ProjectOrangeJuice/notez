<?php
  $se = "SELECT information,id,summary,editKey FROM userPages WHERE userId=?";
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

$side = array(array("inner"=>"onclick=\"document.getElementById('newPageWindow').style.display='block'\"","outter"=>"Create page"),
array("inner"=>"","outter"=>"<a href='/view'>View My Pages</a>"));

$top = array(array("link"=>"href=/settings","text"=>"Settings"),
array("link"=>"onclick='logout()'","text"=>"Logout"));

  $template =  $twig->load("pages.twig");
  echo $template->render(array(
    "sideNavAlt" => $side,
    "topNav" => $top,
    "sideNavTitle"=> "Options",
    "waitingItems" => $waiting

  ));

  ?>
