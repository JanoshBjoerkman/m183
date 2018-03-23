<?php
require_once("config.php");
require_once(CONTROLLER_PATH . "/controller.php");
require_once(CONTROLLER_PATH . "/router.php");
require_once(LIBRARY_PATH . "/db.php");
require_once(MODEL_PATH . "/factory.php");
require_once(LIBRARY_PATH . "/dataextractor.php");

//Constants 
//error codes
define("UNKNOWN_ERROR", 1000);
define("ERR_AMBIGUOUS_USERNAME", 1001);
define("ERR_SIGNUP", 1002);

//alert levels
define("ALERT_SUCCESS", 0);
define("ALERT_INFO", 1);
define("ALERT_WARNING", 2);
define("ALERT_DANGER", 3);

//DB connection
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PWD", "");
define("DB_NAME", "session");
//character encoding for DB connection
define("DB_INIT_COMMAND", "SET NAMES utf8");

//role codes
define("ADMIN_ROLE", "ADM");
define("STANDARD_ROLE", "STD");

//local settings
setlocale(LC_TIME , "de_CH");


// always use session cookie. $_GET['PHPSESSID'] is invalid 
// -> see: http://packetcode.com/article/preventing-session-hijacking-in-php
ini_set( 'session.use_only_cookies', TRUE );				
// send cookies only with HTTPS
// -> see: https://stackoverflow.com/questions/25047170/php-session-cookie-secure-disables-sessions-when-set-to-true
//ini_set( 'session.cookie_secure', TRUE );
ini_set( 'session.cookie_httponly', TRUE );   

//start session
Session::getSession()->refresh();


?>