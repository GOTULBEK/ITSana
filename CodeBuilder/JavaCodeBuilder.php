<?php

namespace CodeBuilder;

use Exception;
use Helper\ArrayHelper;
use Helper\CodeBuilderHelper;
use Helper\Java\JavaBuilderHelper;

class JavaCodeBuilder implements ICodeBuilder{
    private string $resultCode = "";
    public string $activeCode;
    public string $vars;
    const startClassCode = "Main";
    private string $importJson = "import com.fasterxml.jackson.core.JsonProcessingException;\nimport com.fasterxml.jackson.databind.ObjectMapper;
    ";
    public function __construct(string $code = "",array $vars = [],string $activeCode = ""){
        $this->setVars($vars);
        $this->setResultCode($code);
        $this->setActiveCode($activeCode);
    }
    public function setResultCode(string $resultCode){
        $this->resultCode = $resultCode;
    }
    public function setVars(array $vars){
        if(!ArrayHelper::isAssociativeArray($vars)){
            throw new Exception("Input должен быть ассоциативным массивом");
        }
        $this->vars = JavaBuilderHelper::getVarToString($vars);
    }

    public function setActiveCode(string $activeCode){
        $activeCodeSeporator = ["->","::"];
        $sepotator = "";
        foreach ($activeCodeSeporator as &$value) {
            if(strpos($activeCode,$value)){
                list($class,$method) = explode($value,$activeCode);
                $sepotator = $value;
            }
        }
        if(!ArrayHelper::searchArray($sepotator,$activeCodeSeporator)){
            throw new Exception("Вы не правильно активируете класс");
        }
        list($classVar,$classArg) = CodeBuilderHelper::getClassAndArg($class);
        list($methodVar,$methodArg) = CodeBuilderHelper::getMethodAndArg($method);
        $classVarToLower = strtolower($class);
    
        $this->activeCode = $sepotator == "::" ? 
        "\n     System.out.print(new ObjectMapper().writeValueAsString($classVar.$methodVar($methodArg)));" :
        "\n      $classVar $classVarToLower = new $classVar($classArg);\n      System.out.print(new ObjectMapper().writeValueAsString($classVarToLower.$methodVar($methodArg)));
        ";
    }
    public function reset(){
        $this->resultCode = "";
    }
    public function getCode() : string{
        $betweenCodeMain = $this->vars . $this->activeCode;
        return $this->importJson . JavaBuilderHelper::setMainClass(self::startClassCode, $betweenCodeMain) . $this->resultCode;
    }
}