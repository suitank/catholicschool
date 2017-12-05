<?php
  if ($_POST["type"] == "set") {
    session_start();
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["account_id"] = $_POST["account_id"];
    // var_dump($_SESSION);

  }
  else {
    session_start();
    
    session_unset(); 
    session_destroy(); 

    // header( 'Location: /views/login.php' ) ;
  }
    // session_start();
    // $_SESSION = array();
    // if (ini_get("session.use_cookies")) {
    //    $params = session_get_cookie_params();
    //    setcookie(session_name(), '', time() - 42000,
    //     $params["path"], $params["domain"],
    //     $params["secure"], $params["httponly"]
    //    );
    // }
    // session_destroy();
    // echo 'Session was destroyed';

  $response['message'] = 'Success';
  exit(json_encode($response));
?>