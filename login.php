<?php
session_start();// Start session to manage user login
require_once('database.php');// Include the database operations file

// Redirect user if already logged in
if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}
// Check if login form is submitted
if (isset($_POST['login'])) {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    if (authenticateUser($username, $password)) {// Authenticate user
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
    <a href="register.php">Register</a>
</body>
</html>
