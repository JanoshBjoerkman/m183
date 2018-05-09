<?php
require_once(MODEL_PATH . "/user.php");
require_once(CONTROLLER_PATH . "/controller.php");


class BlogController extends Controller {

  public $blogModel;

  public function __construct () {

    parent::__construct();
  }

  public function handleRequest () {

    try {
      $this->userModel = Factory::getUserModel();

      if ($this->userModel->auth->isAuthenticated()) {

        $this->blogModel = Factory::getBlogModel($this->userModel->id);

        if (strcasecmp($_REQUEST["op"], "newpost") == 0) {
          $isSuccessful = $this->blogModel->addPost($this->userModel->id, $_REQUEST["content"]);
          if (!$isSuccessful) {
            $this->setAlert(true, ALERT_DANGER, "Unknown error. Adding new post failed.");
          }
        }

        $this->view = "blog.php"; 
      
      } else {
         $this->setAlert(true, ALERT_DANGER, "Access denied. Please login.");
         Factory::getAuditLogger()->info("Access denied for blog.php", array(
          "time" => date("Y-m-d h:i:sa", time()),
          "username" => $_REQUEST["username"],
          "role" => $this->userModel->role,
          "ip" => $_SERVER["REMOTE_ADDR"]
        ));
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
