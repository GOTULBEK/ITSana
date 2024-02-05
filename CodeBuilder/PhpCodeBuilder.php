<?php

namespace CodeBuilder;

use Exception;
use Helper\ArrayHelper;
use Helper\CodeBuilderHelper;

class PhpCodeBuilder implements ICodeBuilder{
    private string $resultCode = "<?php";
    
    public function __construct(string $code = "",array $vars = [],string $activeCode = ""){
        $this->setResultCode($code);
        $this->setVars($vars);
        $this->setActiveCode($activeCode);
    }

    public function setVars(array $vars){
        if(!ArrayHelper::isAssociativeArray($vars)){
            throw new Exception("Input должен быть ассоциативным массивом");
        }
        foreach($vars as $key => $value){
            $value = json_encode($value);
            $this->resultCode .= "$$key = $value;\n";
        }
    }
    
    public function setActiveCode(string $activeCode){
        if(strpos($activeCode,"->")){
            list($class,$method) = explode("->",$activeCode);
            list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class,"$");
            list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method,"$");
            $this->resultCode .= "$$classVar = new $classVar($classArg);\n";
            $this->resultCode .= "echo json_encode($$classVar->$methodVar($methodArg));";
            return;
        }
        if(strpos($activeCode,"::")){
            list($class,$method) = explode("::",$activeCode);
            list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class,"$");
            list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method,"$");
            $this->resultCode .= "echo json_encode($classVar::$methodVar($methodArg));";
            return;
        }
    
        list($functionVar,$functionArg) = CodeBuilderHelper::getMethodAndArg($activeCode,"$");
        $this->resultCode .= "\necho json_encode($functionVar($functionArg));\n";
    }

    public function setResultCode(string $resultCode){
        $this->resultCode = $resultCode;
    }
    public function reset(){
        $this->resultCode = "<?php";
    }
    public function getCode() : string{
        $resultCode = $this->resultCode;
        $this->reset();
        return $resultCode;
    }
}