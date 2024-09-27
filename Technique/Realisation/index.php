<?php 
require 'vendor/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Library App</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Library Catalog</h1>
        <form method="post" class="mb-8">
            <div class="flex justify-center">
                <input type="text" name="search" placeholder="Search for a book..." class="w-full max-w-md px-4 py-2 rounded-l-lg border-2 border-blue-500 focus:outline-none focus:border-blue-600">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-r-lg hover:bg-blue-600 transition duration-300"><?php echo !empty($_POST['search']) ? 'Search or Clear' : 'Search'; ?></button>
            </div>
        </form>
        <div class="bg-white rounded-lg shadow-md p-6">
            <?php
            if(isset($_POST['search']) && ((is_string($_POST['search']) && !empty($_POST['search'])) || is_integer($_POST['search']))) {
                $bookService = new App\Realisation\Services\BookService();
                $book = $bookService->getBook($_POST['search']);
                if(is_null($book)) {
                    echo "<p class='text-center text-gray-600'>Book not found</p>";
                } else {
                    echo "<div class='space-y-2'>";
                    echo "<h2 class='text-2xl font-semibold text-gray-800'>{$book->getTitle()}</h2>";
                    echo "<p class='text-gray-600'><span class='font-semibold'>Author:</span> {$book->getAuthor()->getFirstName()} {$book->getAuthor()->getLastName()}</p>";
                    echo "<p class='text-gray-600'><span class='font-semibold'>ISBN:</span> {$book->getISBN()}</p>";
                    echo "<p class='text-gray-600'><span class='font-semibold'>Publishing date:</span> {$book->getPublishingDate()}</p>";
                    echo "<p class='text-gray-600'><span class='font-semibold'>Availability:</span> <span class='" . ($bookService->isBookBorrowed($book) ? "text-red-500" : "text-green-500") . "'>" . ($bookService->isBookBorrowed($book) ? "Not available" : "Available") . "</span></p>";
                    echo "</div>";
                }
            } else {
                $books = (new App\Realisation\Services\BookService())->getAvailableBooks();
                if(sizeof($books) === 0) {
                    echo "<p class='text-center text-gray-600'>There are no available books</p>";
                } else {
                    echo "<div class='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>";
                    foreach ($books as $book) {
                        echo "<div class='border rounded-lg p-4 hover:shadow-md transition duration-300'>";
                        echo "<h3 class='text-lg font-semibold text-gray-800 mb-2'>{$book->getTitle()}</h3>";
                        echo "<p class='text-sm text-gray-600'><span class='font-semibold'>Author:</span> {$book->getAuthor()->getFirstName()} {$book->getAuthor()->getLastName()}</p>";
                        echo "<p class='text-sm text-gray-600'><span class='font-semibold'>ISBN:</span> {$book->getISBN()}</p>";
                        echo "<p class='text-sm text-gray-600'><span class='font-semibold'>Publishing date:</span> {$book->getPublishingDate()}</p>";
                        echo "<p class='text-sm text-green-500 font-semibold mt-2'>Available</p>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>