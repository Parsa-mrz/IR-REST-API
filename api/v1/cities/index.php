<?php 
include_once("../../../loader.php");

use App\Services\CityService;
use App\Services\ProvinceValidator;
use App\Utilities\Response;


$request_method = $_SERVER['REQUEST_METHOD'];

$request_body = json_decode(file_get_contents('php://input'),true);

switch($request_method){
    case 'GET':
        $city_service = new CityService();
        $province_id = $_GET['province_id']?? null;
        // validate province id (has somw bug need to fix)
        //! if(!ProvinceValidator::provinceIsvalid($province_id)){
        //!     Response::responseAndDie('Province Not Found',Response::HTTP_NOT_FOUND);
        //! }
        $request_data = [
            'province_id' => $province_id
        ];
        $response = $city_service->getCities($request_data);
        Response::responseAndDie($response,Response::HTTP_OK);

        break; 
    case 'POST':
        Response::responseAndDie('POST Request Method',Response::HTTP_OK);
        
        break;
    case 'PUT':
        Response::responseAndDie('PUT Request Method',Response::HTTP_OK);

        break;
    case 'DELETE':
        Response::responseAndDie('DELETE Request Method',Response::HTTP_OK);
        
        break;
    
    default:
    Response::responseAndDie('Invalid Request Method',Response::HTTP_METHOD_NOT_ALLOWED);
}