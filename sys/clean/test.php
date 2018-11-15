<?php
require_once 'HTMLPurifier.standalone.php';

$config = HTMLPurifier_Config::createDefault();
$config->set('URI.Base', 'http://192.168.1.110'); //Allowed url
$config->set("URI.DisableExternal",true);
$purifier = new HTMLPurifier($config);
$clean_html = $purifier->purify("<SCRIPT>alert('XSS')</SCRIPT><img src='http://board.the-juggernaut.net/plugins/Moon/Assets/images/brand-logo.png'><h1>Hello world</h1><img src='http://192.168.1.110/src/img/aqa.jpg'>");
echo $clean_html;
 ?>
