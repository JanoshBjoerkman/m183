<?php

class Session {

  private static $instance;

  private function __construct () {
    session_start();
  }

  private function __clone () {}

  public static function getSession () {
    
    if (!isset(self::$instance)) {
      self::$instance = new Session ();
    }

    return self::$instance;
  }

  public function isSet ($key) {

    $isSet = false;
    if (isset($_SESSION["$key"])) {
      $isSet = true;
    }

    return $isSet;
  }

  public function get ($key) {

    $value = null;

    if (isSet($key)) {
      $value = $_SESSION["$key"];
    }
    return $value;
  }

  public function set ($key, $value) {
    $_SESSION["$key"] = $value;
  }

  public function unset ($key) {
    unset($_SESSION["$key"]);
  }

  public function destroy () {
    session_destroy();
  }

    
  
}

?>