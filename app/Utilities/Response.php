<?php 

namespace App\Utilities;
class Response{

    public static function respond($data,$status_code){

        return json_encode($data);
    }
}