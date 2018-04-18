<?php
require_once(MODEL_PATH . "/user.php");
require_once(MODEL_PATH . "/forum.php");
require_once(LIBRARY_PATH . "/proprietaryauthentication.php");

class Factory {



  private function __construct() {}
  private function __clone() {}
  
  public static function getUserModel () {

    $session = Session::getSession();

    $userModel = new UserModel ();
    $userModel->auth = new ProprietaryAuthentication ();
    $userModel->session = $session; 

    // if we have an active user session, we always try to load user data
    if ($session->isSet("username") && $session->isSet("pwd")) {
      $userModel->login($session->get("username"), $session->get("pwd"));
    }
    return $userModel;
  }

  public static function getBlogModel ($userId) {

    $blogModel = new BlogModel ();
    $blogModel->loadPosts($userId);
    
    return $blogModel;
  }


  public static function getForumModel () {

    $forumModel = new ForumModel ();
    $forumModel->loadPosts();
    
    return $forumModel;
  }



}
?>