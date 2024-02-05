<?php

use CodeBuilder\JavaCodeBuilder;
use Complier\MainCompiler;

include "autoload.php";

$vars = ["a" => "Hello","b" => "World1!!!"];
$activeCode = "Solution->addTwoStringS(a,b)";
$code = '
class Solution{
    public static String addTwoString(String a,String b){
        return a+" "+b;
    }

    public static int[] getArr(int a,int b){
        int[] c = {a,b};
        return c;
    }
    public String addTwoStringS(String a,String b){
        return a+" "+b;
    }
}';

$mainCompiler = new MainCompiler("java");
$result = $mainCompiler->executeSolution($code,$vars,$activeCode);
var_dump($result);
