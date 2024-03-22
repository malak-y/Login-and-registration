<?php
$db_host = 'localhost';
$db_username = 'username';
$db_password = 'password';
$db_name = 'database_name';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function displayPosts() {
    global $conn;
    $query = "SELECT * FROM posts";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['content'] . "</p>";
        echo "</div>";
    }
}

function authenticateUser($username, $password) {
    global $conn;
    $username = sanitize($username);
    $password = sanitize($password);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
    }
    return false;
}

function registerUser($username, $password) {
    global $conn;
    $username = sanitize($username);
    $password = sanitize($password);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    return mysqli_query($conn, $query);
}
?>
