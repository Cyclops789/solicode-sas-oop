<?php
    require_once 'UserService.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add a new user</title>
</head>
<body>
    <h1>Add a new user</h1>
    <form action="backend.php" method="POST">
        Name: <input type="text" name="nom" required><br>
        Email: <input type="email" name="email" required><br>
        <button type="submit">Ajouter</button>
    </form>

    <div>
        <div>
            List of users
        </div>
        <ul>
            <?php 
                foreach ((new UserService())->getUsers() as $user) {
                    echo "<li>{$user['nom']} - {$user['email']}</li>";
                }
            ?>
        </ul>
    </div>
</body>
</html>