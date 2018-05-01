<?php
require_once(MODEL_PATH . "/user.php");
require_once(MODEL_PATH . "/forum.php");
require_once(LIBRARY_PATH . "/proprietaryauthentication.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Factory
{
  private function __construct() {}
  private function __clone() {}

  private static $auditLogger;
  private static $errorLogger;

  public static function getAuditlogger()
  {
    if(!isset($auditLogger))
    {
      $auditLogger = new Logger("auditLogger");
      $streamHandler = new StreamHandler('./logs/audit.log', Logger::DEBUG);
      $auditLogger->pushHandler($streamHandler);
    }
    return $auditLogger;
  }

  public static function getErrorLogger()
  {
    if(!isset($errorLogger))
    {
      $errorLogger = new Logger("errorLogger");
      $streamHandler = new StreamHandler('./logs/app.log', Logger::DEBUG);
      $errorLogger->pushHandler($streamHandler);
    }
    return $errorLogger;
  }
  
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