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

  // logging
  private static $auditLogger;
  private static $errorLogger;

  // alert mail
  private static $phpMailer;

  public static function sendMail($to, $subject, $body)
  {
    try
    {
      $phpMailer = new PHPMailer();
      //Server settings
      $phpMailer->IsSMTP();                 // enable SMTP
      // $phpMailer->SMTPDebug = 2;            // debugging: 1 = errors and messages, 2 = messages only
      $phpMailer->SMTPAuth = true;          // authentication enabled
      $phpMailer->SMTPSecure = 'ssl';       // secure transfer enabled REQUIRED for Gmail
      $phpMailer->Host = mail_config::$host;
      $phpMailer->Port = mail_config::$port;
      $phpMailer->Username = mail_config::$user;
      $phpMailer->Password = mail_config::$pw;
      $phpMailer->SetFrom(mail_config::$setFrom);

      // recipients
      $phpMailer->AddAddress($to);

      // content
      $phpMailer->IsHTML(true);
      $phpMailer->Subject = $subject;
      $phpMailer->Body = $body;
      $phpMailer->send();
    }
    catch(Exception $e)
    {
      Factory::getErrorLogger($e->getMessage);
    }
  }

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