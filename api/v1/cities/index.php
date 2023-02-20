<?php 
include_once("../../../loader.php");

use App\Services\CityService;
use App\Utilities\Response;

$cs = new CityService();
$result = $cs->getCities([1,2,3,4]);
echo Response::respond($result,Response::HTTP_OK);