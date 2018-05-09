<?php
require_once(MODEL_PATH . "/user.php");
require_once(CONTROLLER_PATH . "/controller.php");


class ForumController extends Controller {

  public $forumModel;

  public function __construct () {

    parent::__construct();
  }

  public function handleRequest () {
    try {
      $this->userModel = Factory::getUserModel();

      if ($this->userModel->auth->isAuthenticated()) {

        $this->forumModel = Factory::getForumModel();

        if (strcasecmp($_REQUEST["op"], "newpost") == 0) {

          // check if csfr token is valid
          if($this->userModel->session->get("csfr") == $_REQUEST['csfr'])
          {
            $isSuccessful = $this->forumModel->addPost($this->userModel->id, $_REQUEST["content"], null);
            if (!$isSuccessful)
            {
              $this->setAlert(true, ALERT_DANGER, "Unknown error. Adding new post failed.");
            }
          }
          else
          {
            Factory::getAuditLogger()->info("csrf token invalid", array(
              "time" => date("Y-m-d h:i:sa", time()),
              "mail" => $this->userModel->mail,
              "role" => $this->userModel->role,
              "ip" => $_SERVER["REMOTE_ADDR"]
            ));
          }

        } elseif (strcasecmp($_REQUEST["op"], "newcomment") == 0) {

          if($this->userModel->session->get("csfr") == $_REQUEST['csfr'])
          {
            $isSuccessful = $this->forumModel->addPost($this->userModel->id, $_REQUEST["content"], $_REQUEST["postid"]);
            if (!$isSuccessful)
            {
              $this->setAlert(true, ALERT_DANGER, "Unknown error. Adding new post failed.");
            }
          }
          else
          {
            Factory::getAuditLogger()->info("csrf token invalid", array(
              "time" => date("Y-m-d h:i:sa", time()),
              "mail" => $this->userModel->mail,
              "role" => $this->userModel->role,
              "ip" => $_SERVER["REMOTE_ADDR"]
            ));
          }
        }

        $this->view = "forum.php"; 
      
      } else {
         $this->setAlert(true, ALERT_DANGER, "Access denied. Please login.");
      }   
    } catch (Exception $e) {
      //something unknown went wrong
      $this->setAlert(true, ALERT_DANGER, $e->getMessage());
      Factory::getErrorLogger()->error($e->getMessage());
    } finally {
      $this->render($this->view, new DataExtractor($this));
    }
  }
}
 ?>
