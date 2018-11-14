<?php


$template =  $twig->load("default.twig");

$url = $_SERVER['REQUEST_URI'];
//get the id of the first or second url
$urls = explode("/",$url);
$naver = array();
if(count($urls)==2){
//subjects
  $fi = "/".$urls[1];
}else{
  array_push($naver, array("subItem"=>"","name"=>$urls[1],"location"=>"/".$urls[1]));

$fi = "/".$urls[1]."/".$urls[2];

}


$stmt = $conn->prepare("SELECT * FROM public WHERE location=?");
if ($stmt->execute(array($fi))) {
  while ($row = $stmt->fetch()) {
  $id = $row["pageId"];
  }
}




$stmt = $conn->prepare("SELECT * FROM public WHERE parent=? and visable=1");
if ($stmt->execute(array($id))) {
  while ($row = $stmt->fetch()) {
  array_push($naver, array("subItem"=>"","name"=>$row["title"],"location"=>$row["location"]));
  }
}


if($login){
  $topNav=$loggedIn;
}else {
  $topNav=$loggedOut;
}

echo $template->render(array(
  'sideNavItems' => $naver,
  'topNav' => $topNav,
  "page"=> $url
));















 ?>
