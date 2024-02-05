<?php

namespace Complier;

use CodeBuilder\PhpCodeBuilder;
use ExecBuilder\PhpExecBuilder;
use Executor\ExecutorResult;
use Helper\FileCompiler;

class PhpCompiler implements ICompiler{
    const key = "php";
    public function compile(string $code,array $input = []) : ExecutorResult {
        $strInput = implode(" ",$input);
        $pathScript = FileCompiler::getFileName(self::key);

        FileCompiler::create($pathScript,$code);
        $startTime = microtime(true);
        exec("php $pathScript $strInput 2>&1", $output,$retval);
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

        $time = $endTime - $startTime;

        $code = FileCompiler::read($path);
        return new ExecutorResult($code,implode($output),(bool)$retval,self::key,$time);
    }
}