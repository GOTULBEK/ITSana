<?php 

function addTwoNum(int $a, int $b):int{
    return $a + $b;
}
$a = 5;

$b = 6;

echo json_encode(addTwoNum($a,$b));