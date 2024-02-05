<?php

namespace CodeBuilder;

interface ICodeBuilder{
    public function __construct(string $code = "",array $vars = [],string $activeCode = "");
    public function setResultCode(string $resultCode);
    public function setVars(array $vars);
    public function setActiveCode(string $activeCode);
    public function reset();
    public function getCode() : string;
}