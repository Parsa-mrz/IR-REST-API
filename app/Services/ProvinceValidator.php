<?php 

namespace App\Services;

class ProvinceValidator{

    public static function provinceIsvalid($data){
        if($data > 31){
            return $data;
        }

    }
}