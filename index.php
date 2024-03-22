
<?php
// This is the main page that  display all the  posts
session_start();// Start session to manage user login
require_once('database.php');// Include the database operations file
if (!isLoggedIn()) {// Redirect user to login page if not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <a href="logout.php">Logout</a>
    <h2>All Posts</h2>
    <?php displayPosts(); ?> // Display all posts
</body>
</html>
