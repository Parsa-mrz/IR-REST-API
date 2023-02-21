<?php 

namespace App\Services;

class ProvinceValidator{

    public static function provinceIsvalid($data){
        if($data < 32){
            return $data;
        }

    }
}