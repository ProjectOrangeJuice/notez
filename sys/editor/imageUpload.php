<?php
if ($_FILES['file']['name']) {
  if (!$_FILES['file']['error']) {
    $uploadOk = 1;
    // Check file size
    if ($_FILES["file"]["size"] > 20000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }$check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {

      $uploadOk = 1;
    } else {

      $uploadOk = 0;
    }

    $name = md5(rand(1, 999));
    $ext = explode('.', $_FILES['file']['name']);
    $filename = $name . '.' . $ext[1];
    $destination = '../../src/img/users/' . $filename; //change this directory
    $imageFileType = strtolower(pathinfo($destination,PATHINFO_EXTENSION));

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    if($uploadOk == 0){
      return;
    }
    while(file_exists($destination)){
      $name = md5(rand(1, 999));
      $filename = $name . '.' . $ext[1];
      $destination = '../../src/img/users/' . $filename;
    }


    $location = $_FILES["file"]["tmp_name"];
    move_uploaded_file($location, $destination);
    echo '/src/img/users/' . $filename;//change this URL
  }
  else
  {
    echo  $message = 'Sorry!  Your upload triggered the following error:  '.$_FILES['file']['error'];
  }
}

?>
