<?php
require_once 'vendor/autoload.php';

// Specify our Twig templates location
$loader = new Twig_Loader_Filesystem('templates');


$options = array(
    'strict_variables' => false,
    'debug' => false,
    'cache'=> false //String location
);

 // Instantiate our Twig
$twig = new Twig_Environment($loader,$options);
?>
