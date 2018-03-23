<?php 

class Session
{
    private static $instance;

    public function __construct()
    {
        $this->refresh();             
    }

    public static function getSession()
    {
        if(!isset(static::$instance))
        {
            static::$instance = new Session();
        }
        return static::$instance;
    }

    public function refresh()
    {
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
        session_regenerate_id(true);
    }

    public function login($username, $pwd)
    {
        $this->refresh();
        $_SESSION['username'] = $username;
        $_SESSION['pwd'] = $pwd;
    }

    public function logout()
    {
        $this->refresh();
        session_unset();
        session_destroy();
    }

    public function isLoggedIn()
    {
        if(isset($_SESSION['username']) && isset($_SESSION['pwd']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>