<?php
session_start();// Start session to manage user login
require_once('database.php');// Include the database operations file

// Redirect user to index page if already logged in
if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['register'])) {// Check if registration form is submitted
    // Sanitize user input
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    if (registerUser($username, $password)) {// Attempt to register the user
        header('Location: login.php'); // Redirect to login page if registration is successful
        exit();
    } else {
        $error = "Registration failed";// Display error message if registration fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="register" value="Register">
    </form>
    <a href="login.php">Login</a>
</body>
</html>
