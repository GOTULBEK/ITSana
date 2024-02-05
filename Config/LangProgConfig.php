<?php

namespace Config;

use Complier\ICompiler;
use Exception;

class LangProgConfig{
    private static array $langCompiler = [
        "php" => \Complier\PhpCompiler::class,
        "python" => \Complier\PythonCompiler::class,
        "java" => \Complier\JavaCompiler::class
    ];

    private static array $langCodeBuilder = [
        "php" => \CodeBuilder\PhpCodeBuilder::class,
        "python" => \CodeBuilder\PythonCodeBuilder::class,
        "java" => \CodeBuilder\JavaCodeBuilder::class
    ];
    
    private static array $langFolderCompiler = [
        "php" => "PHP",
        "python" => "Python",
        "java" => "Java"
    ];
    private static array $langTypeFile = [
        "php" => ".php",
        "python" => ".py",
        "java" => ".java"
    ];

    public static function getLangCompiler(string $key) : ICompiler{
        if(!array_key_exists($key,self::$langCompiler)){
            throw new Exception("Такой язык программирование не существует!");
        }
        return new self::$langCompiler[$key];
    }
    public static function getLangCodeBuilder(string $key,string $code,array $vars,string $activeCode){
        if(!array_key_exists($key,self::$langCodeBuilder)){
            throw new Exception("Такой билдер не существует!");
        }
        return new self::$langCodeBuilder[$key]($code,$vars,$activeCode);
    }
    public static function getLangFolderCompiler(string $key){
        if(!array_key_exists($key,self::$langFolderCompiler)){
            throw new Exception("В нашей конфигураций такой папки не существует!");
        }
        return self::$langFolderCompiler[$key];
    }
    public static function getLangTypeFile(string $key){
        if(!array_key_exists($key,self::$langTypeFile)){
            throw new Exception("В нашей конфигураций такой папки не существует!");
        }
        return self::$langTypeFile[$key];
    }
}