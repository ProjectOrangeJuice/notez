<?php

$bad = '<img src="/src/img/users/96da2f590cd7246bbde0051047b0d6f7.png" alt="96da2f590cd7246bbde0051047b0d6f7.png" style="width: 25%;"><br></p><h2 class="w3-text-orange" style="font-family:Roboto, sans-serif;margin-top:10px;">Lead</h2>';



  require_once 'HTMLPurifier.standalone.php';


  $config = HTMLPurifier_Config::createDefault();
  $config->set('URI.Base', 'https://notez.co.uk'); //Allowed url
  $config->set('HTML.MaxImgLength',NULL)  ;
              $config->set('CSS.MaxImgLength',NULL)  ;
  //allow iframes from trusted sources
  $config->set('Core', 'CollectErrors', true);
  $config->set('HTML.SafeIframe', true);
  $config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%'); //allow YouTube and Vime

  $purifier = new HTMLPurifier($config);
  $clean_html = $purifier->purify($bad);

  echo $clean_html;
 ?>
