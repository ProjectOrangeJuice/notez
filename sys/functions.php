<?php
ini_set('display_errors', 1);
require("config.php");

function sec_session_start() {
    $session_name = 'Notez_Session';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = false;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}


function checkBrute($address,$conn){

  $stmt = $conn->prepare("SELECT attempts
      FROM brute
      WHERE address = :address");
      $stmt->bindParam(':address', $address);
      $stmt->execute();    // Execute the prepared query.
      $row =$stmt->fetch();
      if($row){

         if($row["attempts"] > 5){

           return true;
         }
      }

      return false;

}

function insertBrute($address,$conn){
  $stmt = $conn->prepare("SELECT firstAttempt,attempts
      FROM brute
      WHERE address = :address");
      $stmt->bindParam(':address', $address);
      $stmt->execute();    // Execute the prepared query.
      $row =$stmt->fetch();
      if($row){

        if(!checkRecent($address,$conn)){

          $stmt = $conn->prepare("UPDATE brute SET attempts = 1 , firstAttempt = :first WHERE address = :address");
              $stmt->bindParam(':address', $address);
                $stmt->bindParam(':first', time());
              $stmt->execute();
        }
          else{

        $stmt = $conn->prepare("UPDATE brute SET attempts =  attempts + 1 WHERE address = :address");
            $stmt->bindParam(':address', $address);
            $stmt->execute();
          }

      }else{

        $stmt = $conn->prepare("INSERT INTO brute(address,firstAttempt)
            VALUES(:address,:stamp)");
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':stamp', time());
            $stmt->execute();
      }
}

function checkRecent($addess,$conn){
  $stmt = $conn->prepare("SELECT firstAttempt
      FROM brute
      WHERE address = :address");
      $stmt->bindParam(':address', $address);
      $stmt->execute();    // Execute the prepared query.
      $row =$stmt->fetch();
      if(strtotime("+10 minutes",$row["firstAttempt"])>time() ){
        return true;
      }else{
        return false;
      }

}

function login($username, $password, $conn) {
    // Using prepared statements means that SQL injection is not possible.
    if ($stmt = $conn->prepare("SELECT userId, username, password
        FROM login
       WHERE username = :user
        LIMIT 1")) {
        $stmt->bindParam(':user', $username);  // Bind "$username" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $row =$stmt->fetch();


        if ($row) {
          $user_id= $row["userId"];
          $username = $row["username"];
          $db_password = $row["password"];


                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['REMOTE_ADDR'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                                                "",
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                              $db_password . $user_browser);
                    // Login successful.
                    return true;
                }

        } else {
            // No user exists.
            return false;
        }
    }
}




function login_check($mysqli) {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
                        $_SESSION['username'],
                        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['REMOTE_ADDR'];

        if ($stmt = $mysqli->prepare("SELECT password
                                      FROM login
                                      WHERE userId = :id LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $row =$stmt->fetch();

            if ($row) {

                // If the user exists get variables from result.
                $password=$row["password"];
                $login_check = hash('sha512', $password . $user_browser);

                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}



 ?>
