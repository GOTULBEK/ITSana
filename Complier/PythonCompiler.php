<?php

namespace Complier;

use Executor\ExecutorResult;
use Helper\Env;
use Helper\FileCompiler;

class PythonCompiler implements ICompiler{
    const key = "python";
    public function compile(string $code,array $input = []) : ExecutorResult{
        $strInput = implode(" ",$input);
        $pathScript = FileCompiler::getFileName(self::key);

        FileCompiler::create($pathScript,$code);
        $startTime = microtime(true);
        exec("python3 $pathScript $strInput 2>&1", $output,$retval);
        $endTime = microtime(true);
        FileCompiler::delete($pathScript);

        $time = $endTime - $startTime;

        return new ExecutorResult($code,implode($output),(bool)$retval,self::key,$time);
    }

    public function compileFile(string $path,array $input = []) : ExecutorResult{
        $strInput = implode(" ",$input);
        $startTime = microtime(true);
        exec("php $path $strInput 2>&1", $output,$retval);
        $endTime = microtime(true);
        $code = FileCompiler::read($path);
        $time = $endTime - $startTime;
        return new ExecutorResult($code,implode($output),(bool)$retval,self::key,$time);
    }
}