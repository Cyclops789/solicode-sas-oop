<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $baseDir = __DIR__ . '/';
    $file = $baseDir . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

new App\Interface\ConsoleInterface();