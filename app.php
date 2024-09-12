<?php

spl_autoload_register(function ($class) {
    // Convert namespace to full file path
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Base directory where the classes are located
    $baseDir = __DIR__ . '/src/';

    // Full file path
    $file = $baseDir . $class . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }
});