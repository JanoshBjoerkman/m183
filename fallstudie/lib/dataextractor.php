<?php

//An instance of this class is passed to the render method. A DataExtractor extracts and prepares data for
//the view to be rendered. Data is extracted from the contoller object and its as associated model objects.
class DataExtractor {

  //user data
  private $mail = "";
  private $firstname = "";
  private $lastname = "";
  private $avatar = "";

  //forum
  private $posts;
  private $currentPost;

  // csrf
  private $csfr;

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

      $this->setCSRF($controller);
      $this->setUserData ($controller->userModel);
      $this->setPosts($controller->forumModel->youngestChild);

    
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

  private function setCSRF($controller)
  {
    $this->csfr = base64_encode(random_bytes(100));
    $controller->userModel->session->set("csfr", $this->csfr);
  }

  public function getCSFR()
  {
    return $this->csfr;
  }

  //make previous post to currentPost
  public function issetYoungestChild () {

    $youngestChildExists = false;
    if (isset($this->currentPost->youngestChild)) {
      $youngestChildExists = true;
    }

    return $youngestChildExists;
  }

  public function issetOlderSibling () {

    $olderSiblingExists = false;
    if (isset($this->currentPost->olderSibling)) {
      $olderSiblingExists = true;
    }

    return $olderSiblingExists;
  }

  // set next child to current post
  public function goToYoungestChild () {
    $this->currentPost = $this->currentPost->youngestChild;
  }


  public function goToParent () {
    $this->currentPost = $this->currentPost->parent;
  }

  //make previous post to currentPost
  public function goToOlderSibling () {

    if (isset($this->currentPost)) {
      $this->currentPost = $this->currentPost->olderSibling;
    }
  }

  //returns a string which is used as class name within a HTML template
  //if the post was just commented then it is an active post ("ap"),
  //in all other cases it is an incactive post ("ip")
  //this function is required to set the proper class name within the HTML template
  public function getPostStatus () {
     
    $className = "ip";
    if (isset($_REQUEST["postid"]) && $_REQUEST["postid"] == $this->getPostId()) {
      $className = "ap";
    }
    return $className;
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
  
  
  public function issetCurrentPost () {
    return isset($this->currentPost);
  }

  public function getFirstname () {
    return htmlentities($this->firstname);
  }

  public function getLastname () {
    return htmlentities($this->lastname);
  }

  public function getMail () {
    return htmlentities($this->mail);
  }

  public function getAvatar () {
    return htmlentities($this->avatar);
  }

  public function getPostId () {
    return htmlentities($this->currentPost->id);
  }
  

  public function getPostContent () {

    return htmlentities($this->currentPost->content);
  }

  public function getPosterFirstname () {
    return htmlentities($this->currentPost->firstname);
  }

  public function getPosterLastname () {
    return htmlentities($this->currentPost->lastname);
  }

  public function getPosterAvatar () {
    return htmlentities($this->currentPost->avatar);
  }

  public function getPostDate () {
    return htmlentities(strftime ("%e. %B um Uhr %H:%M:%S", $this->currentPost->postingDate->getTimestamp()));
  }

  
}