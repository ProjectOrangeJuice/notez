<?php
  $se = "SELECT pageId,description,approved FROM page WHERE userId=:user";
  $stmt = $conn->prepare($se);
  $userId = $_SESSION["user_id"];
  $stmt->bindParam(":user",$userId);
  $stmt->execute();

  /* bind result variables */
     $rows =$stmt->fetchAll();

     /* fetch values */
     $waiting = array();
     if($rows){
     foreach($rows as $row) {
       switch ($row["approved"]) {
        case 0:
            $approved = "No";
            break;
        case 1:
            $approved = "Yes";
            break;
        default:
            $approved = "No";
            break;
    }
       array_push($waiting,array("info"=>$row["description"],"key"=>$row["pageId"],"approved"=>$approved));
       }
     }

$side = array(array("inner"=>"onclick=\"document.getElementById('newPageWindow').style.display='block'\"","outter"=>"Create page"));

$top = array(array("link"=>"href=/settings","text"=>"Settings"),
array("link"=>"onclick='logout()'","text"=>"Logout"));

  $template =  $twig->load("editor.twig");
  echo $template->render(array(
    "sideNavAlt" => $side,
    "topNav" => $top,
    "sideNavTitle"=> "Options",
    "waitingItems" => $waiting

  ));

  ?>
