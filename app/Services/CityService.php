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

    public function updateCityName($city_id,$name){
        $result = changeCityName($city_id,$name);
        return $result;
    }

    public function deleteCityName($city_id){
        $result = deleteCity($city_id);
        return $result;
    }
}