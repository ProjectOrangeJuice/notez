<?php


$top = array(array("link"=>"href=/user/editor","text"=>"Editor"),
array("link"=>"onclick='logout()'","text"=>"Logout"));

  $template =  $twig->load("setting.twig");
  echo $template->render(array(
    "topNav" => $top,
    ));

  ?>
