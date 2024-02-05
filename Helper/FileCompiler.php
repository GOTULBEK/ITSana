<?php

namespace Helper;

use Config\LangProgConfig;

class FileCompiler{
    private $path;
    
    public function __construct(string $type){ 
        $this->path = self::getFileName($type);
    }
    public static function create(string $path,string $code){
        $codeFile = fopen($path, 'w');
        fwrite($codeFile, $code);
        fclose($codeFile);
    }
    public static function delete(string $path) : bool{
        return unlink($path);
    }
    public static function read(string $path) : string | false{
        return file_get_contents($path);
    }
    public static function getFileName(string $type) : string{
        $fileName = hash("sha256","index");
        $folderLang = LangProgConfig::getLangFolderCompiler($type);
        $fileType = LangProgConfig::getLangTypeFile($type);
        $folderFilesCompiler = Env::read("PATH_FILES_COMPILER");
        return ".$folderFilesCompiler$folderLang/$fileName$fileType";
    }
    public function createOrDelete(callable $cb,string $code,string $input){
        self::create($this->path,$code);
        $cb($this->path,$input);
        self::delete($this->path);
    }
}