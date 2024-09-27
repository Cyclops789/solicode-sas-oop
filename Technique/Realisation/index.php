<?php 
require 'vendor/autoload.php';
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
    <form method="post">
        <input type="text" name="search">
        <button type="submit">Search</button>
    </form>
    <ul>
        <?php
            if(isset($_POST['search']) && (is_string($_POST['search']) || is_integer($_POST['search']))) {
                $book = (new App\Realisation\Services\BookService())->getBook($_POST['search']);
                $bookService = new App\Realisation\Services\BookService();
                if(is_null($book)) {
                    echo "<li>Book not found</li>";
                } else {
                    echo "<li><strong>ID</strong> : {$book->getId()}</li>";
                    echo "<li><strong>Title</strong> : {$book->getTitle()}</li>";
                    echo "<li><strong>ISBN</strong> : {$book->getISBN()}</li>";
                    echo "<li><strong>Publishing date</strong> : {$book->getPublishingDate()}</li>";
                    echo "<li><strong>Availability</strong> : ".($bookService->isBookBorrowed($book) ? "Not available" : "Available")."</li>";
                    echo "<li><strong>Author</strong> : ".$book->getAuthor()->getFirstName()." ".$book->getAuthor()->getLastName()."</li>";
                }
            } else {
                $books = (new App\Realisation\Services\BookService())->getAvailableBooks();
                echo "<li>###########################################</li>";
                foreach ($books as $book) {
                    echo "<li><strong>ID</strong> : {$book->getId()}</li>";
                    echo "<li><strong>Title</strong> : {$book->getTitle()}</li>";
                    echo "<li><strong>ISBN</strong> : {$book->getISBN()}</li>";
                    echo "<li><strong>Publishing date</strong> : {$book->getPublishingDate()}</li>";
                    echo "<li><strong>Availability</strong> : Available</li>";
                    echo "<li><strong>Author</strong> : ".$book->getAuthor()->getFirstName()." ".$book->getAuthor()->getLastName()."</li>";
                    echo "<li>###########################################</li>";
                }; 
    
                if(sizeof($books) === 0) {
                    echo "<li>There are no available books</li>";
                    echo "<li>###########################################</li>";
                }
            }
        ?>
    </ul> 
</body>
</html>