<?php


$template =  $twig->load("admin.twig");



$stmt = $conn->query("SELECT * FROM public ORDER BY parent ASC");




$items = array();//array of title,location,children,id,parent
$total = array();
  while ($row = $stmt->fetch()) {

      array_push($items,array(
        "name"=>$row["title"],
        "id"=>$row["publicId"],
        "location"=>$row["location"],
        "parent"=>$row["parent"]
      ));

  }

function ordered_list($array,$parent_id = 0)
{
  $temp_array = array();
  foreach($array as $element)
  {
    if ($element['parent'] == $parent_id)
    {
      $element['children'] = ordered_list($array, $element['id']);
      $temp_array[] = $element;
    }
  }
  return $temp_array;
}

$it = ordered_list($items,0);


$side = array(array("inner"=>"onclick='save()'","outter"=>"Save"));



echo $template->render(array( "allPages"=>json_encode($it,JSON_PRETTY_PRINT),
  "sideNavAlt" => $side,));




 ?>
