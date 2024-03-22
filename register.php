<?php
session_start();
require_once('db.php');

// Redirect user if already logged in
if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['register'])) {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    if (registerUser($username, $password)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Registration failed";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog - Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="register" value="Register">
    </form>
    <a href="login.php">Login</a>
</body>
</html>
