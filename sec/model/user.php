<?php

class UserModel {

  public $firstname;
  public $lastname;
  public $mail;
  public $avatar;
  
  public $auth;


  public function __construct () {}

  //verify credentials and - success provided - set user data
  //retruns true if authentication was successful
  public function login ($username, $pwd) {

    $isLoginSuccessful = false;
    $credentials = [
      "username" => $username,
      "pwd" => $pwd
    ];
    $rows = $this->auth->verifyAuthentication($credentials);

    if (isset($rows) && count($rows) == 1) {

      foreach ($rows as $row) {
        $this->firstname = $row->firstname;
        $this->lastname = $row->lastname;
        $this->mail = $row->mail;
      }
      $this->auth->setToAuthenticated();

      //update session variables
      $_SESSION["username"] = $username;
      $_SESSION["pwd"] = $pwd;

      $isLoginSuccessful = true;
    } else {
      $this->auth->setToUnauthenticated();

      //unset session variables
      unset($_SESSION["username"]);
      unset($_SESSION["pwd"]);

      $isLoginSuccessful = false;
    }
    return $isLoginSuccessful;
  } 

  public function logout () {

    $this->auth->setToUnauthenticated();

    //unset session variables
    session_destroy();
  }

  
}

 ?>
