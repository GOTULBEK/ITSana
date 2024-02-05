<?php

namespace Helper;

class Env{
    public static function read(string $key) : string{
        $env = parse_ini_file('.env');
        return $env[$key];
    }
}