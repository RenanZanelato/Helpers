<?php

class Util{
    public static function array_change_key_case_recursive($arrTemp, $case = false){  

        if($case === false){ 
            $case = CASE_LOWER; 
        }
        if($case === true){
            $case = CASE_UPPER;
        }
        $arrTemp = array_change_key_case($arrTemp, $case); 
        foreach($arrTemp as $key=>$array){ 
            if(is_array($array)){ 
                $arrTemp[$key] = self::array_change_key_case_recursive($array, $case); 
            } 
        } 
        return $arrTemp; 
    } 

    public static function onlyNumber($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }
    public static function onlyString($str) {
        return preg_replace("/[^A-Za-zá-üÁ-Ü]/", "", $str);
    }
}