<?php
use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;


ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

date_default_timezone_set("Asia/Tehran");
// Define some absolute path constants to aid in locating resources
define( 'BASE_PATH', dirname( __DIR__ ).'/' );
define( 'APP_PATH', BASE_PATH.'app/' );
define( 'MODULE_PATH', APP_PATH.'Modules/' );
define( 'PROJECT_NAME', basename( BASE_PATH ) );

define('HOST_HASH', substr(md5($_SERVER['HTTP_HOST']), 0, 12));

// Application Envirement
$applicationEnv = 'development';
if( isset( $_SERVER[ 'HTTP_HOST' ] ) )
{
    $applicationEnv = ( ($_SERVER[ 'HTTP_HOST' ] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') ? 'development' : 'production' );
}
define( 'APP_ENV', $applicationEnv );

function dump($value)
{
    if(is_array($value) || is_object($value))
    {
        echo "<pre style='direction: ltr'>";
        print_r($value);
    }
    else{
        print $value;
    }

    die;
}

require_once APP_PATH.'Bootstrap.php';

$bootstrap = new \Ilya\Bootstrap();
$bootstrap->run();