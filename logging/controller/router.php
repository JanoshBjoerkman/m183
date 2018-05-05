<?php

class Router {
    
  public $controller;
  
  public function __construct ()
  {
    // log ip, timestamp and operation for every request
    $timestamp = date('Y-m-d H:i:s');
    $operation = isset($_REQUEST["op"]) ? $_REQUEST["op"] : "";

    $params = array (
      ":ip" => $_SERVER["REMOTE_ADDR"],
      ":timestamp" => $timestamp,
      ":operation" => $operation,
    );

    $sql =
      "insert into request
          (ip, timestamp, operation)
        values
          (:ip, :timestamp, :operation)";
    $stmts = array (
      array ($sql, $params)
    );
    $success = DB::getConnection()->insertOrUpdate($stmts);

    //handling forms
    if (isset($_REQUEST["op"])) {

      if ((strcasecmp($_REQUEST["op"], "login-form") == 0) ||
          (strcasecmp($_REQUEST["op"], "login-action") == 0) ||
          (strcasecmp($_REQUEST["op"], "logout") == 0) ||
          (strcasecmp($_REQUEST["op"], "signup-form") == 0) ||
          (strcasecmp($_REQUEST["op"], "signup-action") == 0)) {

        require_once(CONTROLLER_PATH . "/user.php"); 
        $this->controller = new UserController();
      
      } elseif ((strcasecmp($_REQUEST["op"], "forum") == 0)  ||
                (strcasecmp($_REQUEST["op"], "newpost") == 0) ||
                (strcasecmp($_REQUEST["op"], "newcomment") == 0)) {

        require_once(CONTROLLER_PATH . "/forum.php"); 
        $this->controller = new ForumController();

      } elseif (strcasecmp($_REQUEST["op"], "pct") == 0) {

        require_once(CONTROLLER_PATH . "/codetest.php"); 
        $this->controller = new CodetestController();

      }
    }

    if (is_null($this->controller)) {
      require_once(CONTROLLER_PATH . "/home.php"); 
      $this->controller = new HomeController();
    }    
  }       
}
    
?>