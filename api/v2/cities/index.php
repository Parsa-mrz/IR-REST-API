<?php 
include_once("../../../loader.php");
include_once("../../../App/Utilities/CacheUtilities.php");
use App\Services\CityService;
use App\Utilities\Response;
use App\Utilities\CacheUtilities;

// Check authorization(JWT)
$token = getBearerToken();
if($token == null){
    Response::responseAndDie('Invalid API Token',Response::HTTP_UNAUTHORIZED);
}
$user = isValidToken($token);
if(!$user or $token == null){
    Response::responseAndDie('Invalid API Token',Response::HTTP_UNAUTHORIZED);
}

$request_method = $_SERVER['REQUEST_METHOD'];
$request_body = json_decode(file_get_contents('php://input'),true);
$city_service = new CityService();

switch($request_method){ 
    case 'GET':
        $province_id = $_GET['province_id']?? null;
        if(!hasAccessToProvince($user,$province_id)){
            Response::responseAndDie('You have no access to this province',Response::HTTP_FORBIDDEN);
        }
        CacheUtilities::start();
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
        echo Response::respond($response,Response::HTTP_OK);
        CacheUtilities::end();

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