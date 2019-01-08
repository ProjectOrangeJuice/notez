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


$stmt = $conn->prepare("SELECT * FROM public,page,login WHERE public.location=? AND page.userId = login.userId AND public.pageId=page.pageId");
if ($stmt->execute(array($fi))) {
  while ($row = $stmt->fetch()) {
  $id = $row["publicId"];

  }
}



$sublists = array();
$stmt = $conn->prepare("SELECT * FROM public WHERE parent=? and visable=1");
if ($stmt->execute(array($id))) {
  while ($row = $stmt->fetch()) {
    $breaker = explode(".",$row["title"]);
    if($breaker[1]){
      $sublists[$breaker[0]] .= $row["title"]."-".strtolower($row["location"]).",";
    }else{
        array_push($naver, array("subItem"=>"","name"=>$row["title"],"location"=>strtolower($row["location"]),"si"=>false));
    }
  }
}

foreach ($sublists as $key => $value) {
  $temp = array();
    $splitThis = explode(",",$value);
    $matched = false;
    foreach($splitThis as $value2){
      $splitOther = explode("-",$value2);
      if(strtolower($url) == $splitOther[1]){ $match = true;$matched = true;}else{$match=false;}
array_push($temp, array("subItem"=>"","name"=>$splitOther[0],"location"=>strtolower($splitOther[1]),"si"=>false,"match"=>$match));
    }
    array_pop($temp);
    array_push($naver, array("subItem"=>$temp,"name"=>$key,"location"=>"","si"=>true,"matched"=>$matched));

}





//page content
$stmt = $conn->prepare("SELECT *
    FROM page,public,login
    WHERE public.location = :page AND public.pageId=page.pageId AND login.userId = page.userId");
    $stmt->bindParam(':page',$url);  // Bind "$username" to parameter.
    $stmt->execute();    // Execute the prepared query.
    $row =$stmt->fetch();
    if($row){
      $change = $row["edited"]." By <a href='/u?".$row["username"]."'>".$row["username"]."</a>";
      $title = $row["title"];
      $desc = $row["description"];
      $page = $row["content"];
      $pid = $url;
    }else{
    $page =  "Page can't be accessed";
    }


if($login){
  $topNav=$loggedIn;
}else {
  $topNav=$loggedOut;
}

echo $template->render(array(
  "title" => "Notez - ".$title,
  "desc" => $desc,
  'sideNavItems' => $naver,
  'topNav' => $topNav,
  "page"=> $page,
  "pid"=> $pid,
  "footer"=>$change,
  "searchBox"=>"yes",
));















 ?>
