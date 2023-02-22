<?php 
include_once("../../../loader.php");

use App\Services\CityService;
use App\Services\ProvinceValidator;
use App\Utilities\Response;


$request_method = $_SERVER['REQUEST_METHOD'];
$request_body = json_decode(file_get_contents('php://input'),true);
$city_service = new CityService();

switch($request_method){ 
    case 'GET':
        $province_id = $_GET['province_id']?? null;
        $request_data = [
            'province_id' => $province_id,
            'page' => $_GET['page'] ?? null,
            'pagesize' => $_GET['pagesize'] ?? null,
            'fields' => $_GET['fields'] ?? null,
            'orderby' => $_GET['orderby'] ?? null
        ];
        $response = $city_service->getCities($request_data);
        // validate province id
        if(empty($response)){
            Response::responseAndDie('Invalid Province Data',Response::HTTP_NOT_FOUND);
        }
        Response::responseAndDie($response,Response::HTTP_OK);

        break; 

    case 'POST':
        if(!isValidCity($request_body)){
            Response::responseAndDie('Invalid city data',Response::HTTP_NOT_ACCEPTABLE);
        }
        $response = $city_service->createCity($request_body);
        Response::responseAndDie($response,Response::HTTP_CREATED);
        break;

    case 'PUT':
        [$city_id,$city_name] = [$request_body['city_id'],$request_body['name']];
        if(!is_numeric($city_id) or empty($city_name)){
            Response::responseAndDie('Invalid City Data',Response::HTTP_NOT_ACCEPTABLE);
        }
        $response = $city_service->updateCityName($city_id,$city_name);
        if(empty($response)){
            Response::responseAndDie('No Record Updated',Response::HTTP_NOT_FOUND);
        }
        Response::responseAndDie($response,Response::HTTP_OK);

        break;

    case 'DELETE':
        $city_id = $_GET['city_id'] ?? null;
        if(!is_numeric($city_id) or is_null($city_id)){
            Response::responseAndDie('Invalid City Data',Response::HTTP_NOT_ACCEPTABLE);
        }
        $response = $city_service->deleteCityName($city_id);
        if(empty($response)){
            Response::responseAndDie('Invalid City Data',Response::HTTP_NOT_FOUND);
        }
        Response::responseAndDie($response,Response::HTTP_OK);
        
        break;
    
    default:
    Response::responseAndDie('Invalid Request Method',Response::HTTP_METHOD_NOT_ALLOWED);
}