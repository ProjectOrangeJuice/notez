<?php
ini_set('display_errors', 1);
require_once __DIR__.'/bootstrap.php';
include_once 'sys/connection.php';
include_once 'sys/functions.php';
$url = $_SERVER['REQUEST_URI'];
sec_session_start();
if(strpos($url,"?") !==false){
list($url,$ending) = explode("?",$url,2);
}
$login = login_check($conn);

//$loggedIn = array(array("link"=>"href=/user/editor","text"=>"Editor"),array("link"=>"","text"=>"Edit"),
//array("link"=>"onclick='logout()'","text"=>"Logout"));
$loggedIn = array(array("link"=>"href=/user/editor","text"=>"Editor"),array("link"=>"onclick='logout()'","text"=>"Logout"));
$loggedOut = array(array("link"=>"onclick='showLogin()'","text"=>"<i class='fa fa-sign-in'></i><span class='w3-hide-small'>Login</span>"),
array("link"=>"onclick='showRegister()'","text"=>"<i class='fa fa-user-plus'></i><span class='w3-hide-small'>Register</span>"));

$indexArray = array("/","/index.html","/index.php");

if(in_array($url,$indexArray)){

require("gen/index.php");

}else if($url == "/user/editor"){

require("gen/editor.php");

}else if($url == "/user/edit"){

require("gen/edit.php");

}else if($url == "/mod"){

require("gen/mod.php");

}else if ($url == "/admin"){ //secure this

require("gen/admin.php");

}else if($url == "/pages"){

require("gen/pages.php");

}else if($url == "/view"){

require("gen/view.php");

}else {

require("gen/default.php");

}





?>
