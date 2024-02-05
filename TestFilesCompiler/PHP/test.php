<?php

$arguments = $_SERVER['argv'];
array_shift($arguments);

function argDecode($args):array{
    $result = [];
    foreach ($args as $key => $arg) {
     if(strpos($arg,"=")){
        list($key, $value) = explode('=', $arg);
        $value = json_decode(str_replace("'",'"',$value),true);
        $result[$key] = $value;
     }else{
        $result[$key] = $arg;
     }
    }
    return $result;
}
var_dump(argDecode($arguments));

?>
