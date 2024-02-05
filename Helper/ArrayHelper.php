<?php

namespace Helper;

class ArrayHelper{
    public static function isAssociativeArray(array $array) : bool {
        foreach($array as $key => $value){
            if(is_numeric($key)){
                return false;
            }
        }
        return true;
    }

    public static function arrayToStringList(array $array) : string{
        $result = "";
        foreach($array as $key => $value){
            if(!is_numeric($key)){
                $result .= $key.'='.str_replace('"',"'",json_encode($value,true)).' ';
            }else{
                $result .= $value.' ';
            }
        }
        return $result;
    }

    public static function searchArray(mixed $needle,array $haystack): bool{
        foreach ($haystack as $key => $value) {
            if($value === $needle){
                return true;
            }
        }
        return false;
    }
}