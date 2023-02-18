<?php 

include_once('App/iran.php');

spl_autoload_register(function ($class){
    $class_file = __DIR__ . '/' . $class . '.php';
    echo $class_file;
    include_once($class_file);
});

use App\Services\CityService;
use App\Utilities\Response;
 new CityService();
