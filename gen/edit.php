<?php
$top = array(array("link"=>"href=/user/editor","text"=>"Editor"),
array("link"=>"onclick='logout()'","text"=>"Logout"));




$side = array(array("inner"=>"onclick='save()' id='save'","outter"=>"Save"),
array("inner"=>"onclick='submit()' id='submit'","outter"=>"Submit"),
array("inner"=>"onclick='deleter()'","outter"=>"DELETE"));


$template =  $twig->load("edit.twig");
echo $template->render(array(
  "sideNavAlt" => $side,
  "topNav" => $top,
  "sideNavTitle"=> "Options",
  "page"=>$ending,
  "delKey"=>$ending
));


 ?>
