<?php 

namespace App\Services;

class CityService{

    public function getCities($data){
        $result = getCities($data);
        return $result;
    }

    public function createCity($data){
        $result = addCity($data);
        return $result;
    }
}