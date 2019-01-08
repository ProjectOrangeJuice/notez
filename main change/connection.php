<?php

try {
$conn = new PDO("mysql:host=localhost;dbname=harrisoc_n2", "harrisoc_n2", "@?;PYdWkr7N0");
 } 
    catch(PDOException $exception){ 
       echo $exception->getMessage(); 
    } 
   // set the PDO error mode to exception
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



 ?>
