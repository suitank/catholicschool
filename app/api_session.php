<?php
  include_once 'utility_functions.php';

  if (test_input($_POST["type"]) == "set") {
    if(!isset($_SESSION)){
      session_start();
    }
    $_SESSION["email"] = test_input($_POST["email"]);
    $_SESSION["account_id"] = test_input($_POST["account_id"]);
    // var_dump($_SESSION);

  }
  else {
    if(!isset($_SESSION)){
      session_start();
    }
    
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