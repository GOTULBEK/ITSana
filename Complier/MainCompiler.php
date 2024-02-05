<?php

namespace Complier;

use CodeBuilder\ICodeBuilder;
use Config\LangProgConfig;
use Exception;
use Executor\ExecutorResult;
use Helper\ArrayHelper;

class MainCompiler{
    private $compiler;
    private $input = [];

    public function __construct(ICompiler | string $compiler,array $input = [])
    {
        $this->compiler = $compiler instanceof ICompiler 
        ? $compiler : $this->getCompiler($compiler);
        
        $this->setInput($input);
    }

    public function execute(string $code,array $input = []) : ExecutorResult{
        $input = count($input) ? $input : $this->input; 
        return $this->compiler->compile($code,$input);
    }

    private function getCompiler(string $key) : ICompiler{
        return LangProgConfig::getLangCompiler($key);
    }
    private function getCodeBuilder(string $key,string $code,array $vars,string $activeCode): ICodeBuilder{
        return LangProgConfig::getLangCodeBuilder($key,$code,$vars,$activeCode);
    }

    public function executeFromFile(string $path,array $input = []) : ExecutorResult{
        $input = count($input) ? $input : $this->input; 
        return $this->compiler->compileFile($path,$input);
    }
    public function executeSolution(string $code,array $vars,string $activeCode):ExecutorResult{
        if(!ArrayHelper::isAssociativeArray($vars)){
            throw new Exception("Vars должен быть ассоциативным массивом");
        }
        $codeBuilder = $this->getCodeBuilder($this->compiler::key,$code,$vars,$activeCode);
        return $this->compiler->compile($codeBuilder->getCode(),$this->input);
    }

    public function setInput(array $input){
        $this->input = $input;
    }
}