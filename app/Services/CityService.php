<?php 

namespace App\Services;

class CityService{

    public function getCities($data){
        $result = getCities($data);
        return $result;
    }
}