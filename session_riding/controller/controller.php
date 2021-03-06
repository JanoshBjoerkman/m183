<?php
require_once(LIBRARY_PATH . "/session.php");

abstract class Controller {

  //all instances of Controller subclasses must reference an object of typ UserModel
  //instances of Controller subclasses may reference additional models
  public $userModel;
 

  //view which will be initiated for the resposne
  public $view;

  //previous view, view of the previous response
  public $prevView;

  //general conditions, states, exceptions, alerts
  public $showAlert = false;
  public $alertLevel; 
  public $alertMsg;

  public function __construct () {

    $this->session = Session::getSession();

    //get previous view
    //set default of next view, may be overwritten by handleRequest method of called controller
    if ($this->session->isSet("prevview")) {
      $this->prevView = $this->session->get("prevview");
      $this->view = $this->prevView;
    } else {
      $this->view = "home.php";
    }

  }

  public function handleRequest () {}
  
  public function render ($view, $data) {
      $this->session->set("prevview", $view);
      require_once(VIEW_PATH . "/" . $view);
  }

  public function setAlert ($showAlert, $alertLevel, $alertMsg) {
    $this->showAlert = $showAlert;
    $this->alertLevel = $alertLevel;
    $this->alertMsg = $alertMsg;
  }
    
  
}

?>