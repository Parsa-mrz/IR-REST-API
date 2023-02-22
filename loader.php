<?php 

// cache constants 
define('CACHE_DIR',__DIR__.'/cache');
define('CACHE_ENABLE',0);

// authorization constant 
define("JWT_ALG","HS256");
define('JWT_KEY','parsaIranApiKey8489df%$^&YG89ywe89');

include("vendor/autoload.php");
include_once('App/iran.php');

spl_autoload_register(function ($class){
    $class_file = __DIR__ . '/' .  str_replace('\\', '/', $class) . ".php";
    if(!(file_exists($class_file) and is_readable($class_file))){
        die("$class not found");
    }
    include_once $class_file;
});