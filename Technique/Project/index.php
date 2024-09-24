<?php

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $baseDir = __DIR__ . '/';
    $file = $baseDir . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
</head>
<body>
    <strong>Books</strong>
    <ul>
        <?php 
            foreach ((new App\Models\Book())->getAllBooks() as $book) {
                echo "<li>#{$book['id']} - {$book['title']}</li>";
            }; 
        ?>
    </ul> 
</body>
</html>