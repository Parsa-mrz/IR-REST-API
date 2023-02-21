<?php 

namespace App\Services;

class ProvinceValidator{

    public static function provinceIsvalid($data){
        $province = getProvinces($data);
        if (isset($province)) {
            return $province;
        }
    }
}