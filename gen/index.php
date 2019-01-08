<?php

$template =  $twig->load("index.twig");





$stmt = $conn->query("SELECT * FROM public WHERE parent=0 AND visable=1");
$naver = array();
while ($row = $stmt->fetch()) {
    array_push($naver, array("subItem"=>"","name"=>$row["title"],"location"=>$row["location"]));
}

if($login){
  $topNav=$loggedIn;
}else {
  $topNav=$loggedOut;
}

echo $template->render(array(
  'sideNavItems' => $naver,
  "desc" => "This site contains a set of notes for each exam  board. Helping you to learn what you need for your exam",
  'topNav' => $topNav
));



 ?>
