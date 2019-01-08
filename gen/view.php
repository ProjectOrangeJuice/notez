<?php
$top = array(array("link"=>"href=/user/editor","text"=>"Editor"),
array("link"=>"onclick='logout()'","text"=>"Logout"));

$template =  $twig->load("view.twig");


if(isset($ending)){
  $stmt = $conn->prepare("SELECT * FROM page,login where pageId = ? AND page.userId = login.userId");
  if ($stmt->execute(array($ending))) {
    while ($row = $stmt->fetch()) {
      $content = $row["pageId"];
      $desc = $row["description"];
      $user = $row["username"];
    }
  }
}else{
$content = "No key given";






}

  echo $template->render(array(

    "topNav" => $top,
    "desc"=> $desc,
    "user"=> $user,
    "content" => $content

  ));

 ?>
