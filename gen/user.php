<?php
$template =  $twig->load("user.twig");

#ending is user

$se = "SELECT * FROM page,public,login WHERE public.pageId = page.pageId AND page.userId=login.userId AND login.username=:user
 and page.approved = 1";
$stmt = $conn->prepare($se);
$stmt->bindParam(":user",$ending);
$stmt->execute();

/* bind result variables */
   $rows =$stmt->fetchAll();

   /* fetch values */
   $pages= array();
   if($rows){
   foreach($rows as $row) {

     array_push($pages,array("title"=>$row["title"],"info"=>$row["description"],"location"=>$row["location"],"edited"=>$row["edited"]));
     }
   }


$side = array(array("inner"=>"onclick=\"alert('Unable to do this')\"","outter"=>"Message user"));

if($login){
  $topNav=$loggedIn;
}else {
  $topNav=$loggedOut;
}

echo $template->render(array(
  "title" => "Notez user - ".$ending,
  "desc" => "User page for ".$ending,
  "sideNavAlt" => $side,
  "topNav" => $topNav,
  "sideNavTitle"=> "Options",
  "user"=> $ending,
  "pages"=>$pages
));















 ?>
