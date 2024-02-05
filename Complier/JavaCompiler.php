<?php

namespace Complier;

use ExecBuilder\PhpExecBuilder;
use Executor\ExecutorResult;
use Helper\FileCompiler;

class JavaCompiler implements ICompiler{
    const key = "java";
    public function compile(string $code,array $input = []) : ExecutorResult{
        $strInput = implode(" ",$input);
        $pathScript = FileCompiler::getFileName(self::key);

        FileCompiler::create($pathScript,$code);
        $startTime = microtime(true);
        exec("java $pathScript $strInput 2>&1", $output,$retval);
        $endTime = microtime(true);

        $time = $endTime - $startTime;

        FileCompiler::delete($pathScript);
        
        return new ExecutorResult($code,implode($output),(bool)$retval,self::key,$time);
    }
    public function compileFile(string $path,array $input = []) : ExecutorResult{
        $strInput = implode(" ",$input);
        $startTime = microtime(true);
        exec("java $path $strInput 2>&1", $output,$retval);
        $endTime = microtime(true);
        $code = FileCompiler::read($path);
        $time = $endTime - $startTime;
        return new ExecutorResult($code,implode($output),(bool)$retval,self::key,$time);
    }
}