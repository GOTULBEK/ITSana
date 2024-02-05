<?php

namespace Helper;

class CodeBuilderHelper{
    public static function getArgToArray(string $data) : array{
        $brackets_start = strpos($data,"(");
        $brackets_end = strpos($data,")");

        if(strlen(trim(substr($data,$brackets_start,$brackets_end),"()"))){
            return explode(",",trim(substr($data,$brackets_start,$brackets_end),"()"));
        }
        return [];
    }
    private static function getClassOrMethod(string $methodOrClass) : string{
        return preg_split('/[(*)]/', $methodOrClass)[0];
    }

    public static function getArgToString(array $arg,string $seporator = "") : string{
        if(!count($arg))return "";

        for($i = 0; $i < count($arg); $i++){
            $arg[$i] = $seporator.$arg[$i];
        }
        return implode(",",$arg);
    }
    public static function getClass(string $class) : string{
        return self::getClassOrMethod($class);
    }
    public static function getMethod(string $method): string{
        return self::getClassOrMethod($method);
    }

    public static function getClassAndArg(string $class,string $seporator = "") : array{
        return [self::getClass($class),
                self::getArgToString(
                    self::getArgToArray($class),
                    $seporator)];
    }
    public static function getMethodAndArg(string $class,string $seporator = "") : array{
        return self::getClassAndArg($class,$seporator);
    }
    public static function checkActiveFunction(string $function) : bool{
        $brackets_arr = ["(",")"];
        for ($i = 0; $i < count($brackets_arr); $i++) { 
            if(strpos($function,$brackets_arr[$i])){
                return true;
            }
        }
        return false;
    }
    public static function getMicroTime(callable $cb) : float{
        $startTime = microtime(true);
        $cb();
        $endTime = microtime(true);
        return $endTime - $startTime;
    }
}