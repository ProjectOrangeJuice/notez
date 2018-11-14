<?php

$template =  $twig->load("mod.twig");

$side = array(array("inner"=>"onclick=\"document.getElementById('window').style.display='block'\"","outter"=>"Accept"),
array("inner"=>"onclick=\"decline()\"","outter"=>"Decline"),
array("inner"=>"onclick=\"loadPage()\"","outter"=>"Load"),
array("inner"=>"onclick=\"skipPage()\"","outter"=>"Skip"));

$top = array(array("link"=>"href=/editor","text"=>"Editor"));

echo $template->render(array(
  'sideNavAlt' => $side,
  'topNav' => $top
));



 ?>
