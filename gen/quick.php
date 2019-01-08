<?php


$template =  $twig->load("search.twig");
$search = $_GET["search"];
$sea = array();
$stmt = $conn->prepare("SELECT * FROM search,public,page WHERE
search.location = public.location AND public.pageId = page.pageId AND search.search LIKE :search");
$search = "%".$search."%";

$stmt->bindValue(":search", $search, PDO::PARAM_STR);
if ($stmt->execute()) {
  while ($row = $stmt->fetch()) {


      array_push($sea, array("title"=>$row["title"],"info"=>$row["description"],"location"=>$row["location"],"edited"=>$row["edited"]));

  }
}


if($login){
  $topNav=$loggedIn;
}else {
  $topNav=$loggedOut;
}

echo $template->render(array(
"search" => $sea,
"svalue" => $_GET["search"],
"searchBox" => "yes",
));















 ?>
