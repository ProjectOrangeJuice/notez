<?php

ini_set('display_errors', 1);
function generateImage($imageLoc){
  $image = imagecreatefromstring(file_get_contents($imageLoc));
  $filename = $imageLoc ;

  $thumb_width = 200;
  $thumb_height = 150;

  $width = imagesx($image);
  $height = imagesy($image);

  $original_aspect = $width / $height;
  $thumb_aspect = $thumb_width / $thumb_height;

  if ( $original_aspect >= $thumb_aspect )
  {
     // If image is wider than thumbnail (in aspect ratio sense)
     $new_height = $thumb_height;
     $new_width = $width / ($height / $thumb_height);
  }
  else
  {
     // If the thumbnail is wider than the image
     $new_width = $thumb_width;
     $new_height = $height / ($width / $thumb_width);
  }

  $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

  // Resize and crop
  imagecopyresampled($thumb,
                     $image,
                     0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                     0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                     0, 0,
                     $new_width, $new_height,
                     $width, $height);
  imagejpeg($thumb, $filename, 80);
}


function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp );
    generateImage($output_file);
    return $output_file;
}


base64_to_jpeg("data:image/jpg;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASAgMAAAAroGbEAAAACVBMVEUAAIjd6vvD2f9LKLW+AAAAAXRSTlMAQObYZgAAAAFiS0dEAIgFHUgAAAAJcEhZcwAACxMAAAsTAQCanBgAAAAHdElNRQfYAR0BKwNDEVT0AAAAG0lEQVQI12NgAAOtVatWMTCohoaGUY+EmIkEAEruEzK2J7tvAAAAAElFTkSuQmCC","bla");

 ?>
