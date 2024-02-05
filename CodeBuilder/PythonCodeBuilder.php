<?php

namespace CodeBuilder;

use Exception;
use Helper\ArrayHelper;
use Helper\CodeBuilderHelper;

class PythonCodeBuilder implements ICodeBuilder{
    private string $resultCode = "";
    private string $importJson = "import json\n";
    public function __construct(string $code = "",array $vars = [],string $activeCode = ""){
        $this->setResultCode($code);
        $this->setVars($vars);
        $this->setActiveCode($activeCode);
    }
    public function setResultCode(string $resultCode){
        $this->resultCode = $this->importJson . $resultCode;
    }
    public function setVars(array $vars){
        if(!ArrayHelper::isAssociativeArray($vars)){
            throw new Exception("Input должен быть ассоциативным массивом");
        }
        foreach($vars as $key => $value){
            $value = json_encode($value);
            $this->resultCode .= "\n$key = $value\n";
        }
    }
    public function setActiveCode(string $activeCode){
        if(strpos($activeCode,"->")){
            list($class,$method) = explode("->",$activeCode);
            list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class);
            list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method);
            $this->resultCode .= "$classVar = $classVar($classArg)\n";
            $this->resultCode .= "print(json.dumps($classVar.$methodVar($methodArg)))";
            return;
        }
        if(strpos($activeCode,"::")){
            list($class,$method) = explode("::",$activeCode);
            list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class);
            list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method);
            $this->resultCode .= "print(json.dumps($classVar::$methodVar($methodArg)))";
            return;
        }
    
        list($functionVar,$functionArg) = CodeBuilderHelper::getMethodAndArg($activeCode);
        $this->resultCode .= "\nprint(json.dumps($functionVar($functionArg)))\n";
    }
    public function reset(){
        $this->resultCode = "";
    }
    public function getCode() : string{
        $resultCode = $this->resultCode;
        $this->reset();
        return $resultCode;
    }
}