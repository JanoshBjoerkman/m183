<?php

//An instance of this class is passed to the render method. A DataExtractor extracts and prepares data for
//the view to be rendered. Data is extracted from the contoller object and its as associated model objects.
class DataExtractor {

  //user data
  public $mail = "";
  public $firstname = "";
  public $lastname = "";
  public $avatar = "";

  //forum
  public $posts;
  public $currentPost;


  //authentication, authorization
  public $isAuthenticated = false;
  public $role = "";

  //conditions, states, exceptions
  public $currentView = "";

  //codetest data, just for testing purpose
  public $phpcode = "";

  //alerts
  public $showAlert = false;
  public $alertLevel = 0; 
  public $alertMsg = "";

  //helpers
  private $bsAlertLevels;

  public function __construct ($controller) {

    $this->initHelpers();
    $this->setAlertBox($controller);
    $this->currentView = $controller->view;

    if ($controller instanceof UserController) {
      
      $this->setUserData($controller->userModel);
  
    } elseif ($controller instanceof BlogController) {

      $this->setUserData ($controller->userModel);
      $this->posts = $controller->blogModel->posts;

    } elseif ($controller instanceof ForumController) {

      $this->setUserData ($controller->userModel);
      $this->setPosts($controller->forumModel->posts);

    
    } elseif ($controller instanceof HomeController) {

      $this->setUserData ($controller->userModel);
    }
    elseif ($controller instanceof CodetestController) {

      $this->setUserData ($controller->userModel);
      if (isset($controller->phpcode)) {
        $this->phpcode = $controller->phpcode;
      }

    }
  }

  private function setUserData ($userModel) {

    //set user data
    if (isset($userModel->mail)){
      $this->mail = $userModel->mail;
    }
    if (isset($userModel->firstname)){
      $this->firstname = $userModel->firstname;
    }
    if (isset($userModel->lastname)){
      $this->lastname = $userModel->lastname;
    }
    if (isset($userModel->avatar)){
      $this->avatar = $userModel->avatar;
    }
    if (isset($userModel->role)) {
      $this->role = $userModel->role;
    }
    if (isset($userModel->auth)){
      $this->isAuthenticated = $userModel->auth->isAuthenticated();
    }
  }

  private function setAlertBox ($controller) {

    if (isset($controller->showAlert)){
      $this->showAlert = $controller->showAlert;
    }
    if (isset($controller->alertLevel)){
      $this->alertLevel = $controller->alertLevel;
    }
    if (isset($controller->alertMsg)){
      $this->alertMsg = $controller->alertMsg;
    }
  }

  public function getBsAlertLevel () {
    
    return $this->bsAlertLevels[$this->alertLevel];
  }

  private function initHelpers () {

    $this->bsAlertLevels = [
      ALERT_SUCCESS => "alert-success",
      ALERT_INFO => "alert-info",
      ALERT_WARNING => "alert-warning",
      ALERT_DANGER => "alert-danger"
    ];
  }

  public function isAdminUser () {

    $isAdminUser = false;

    if ($this->role == ADMIN_ROLE) {
      $isAdminUser = true;;
    }

    return $isAdminUser;
  }

  public function isStandardUser () {

    $isStandardUser = false;

    if ($this->role == STANDARD_ROLE) {
      $isStandardUser = true;;
    }

    return $isStandardUser;
  }

  //set posts and make most recent post to currentPost
  public function setPosts ($posts) {
    $this->posts = $posts;
    $this->currentPost = $posts;
  }
  
  //make previous post to currentPost
  public function goToPrevPost () {

    if (isset($this->currentPost)) {
      $this->currentPost = $this->currentPost->previousPost;
    }
  }

}