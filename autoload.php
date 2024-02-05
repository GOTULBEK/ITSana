<?php
spl_autoload_register(function ($class) {
    // replace namespace separators with directory separators and append with .php
    $file = str_replace('\\', '/', $class . '.php');
    if (file_exists($file)) {
        require $file;
    }
});