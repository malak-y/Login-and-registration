<?php
// Database connection parameters
$db_host = 'localhost';
$db_username = 'username';
$db_password = 'password';
$db_name = 'database_name';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);// Establish database connection

if (!$conn) {// Check if connection is successful
    die("Connection failed: " . mysqli_connect_error());
}

function sanitize($data) {// Function to sanitize user input data
    global $conn;// Access the global database connection object
    return mysqli_real_escape_string($conn, $data);// Escape special characters in the input data
}

function isLoggedIn() {// Function to check if user is logged in
    // Check if 'user_id' session variable is set
    return isset($_SESSION['user_id']);
}
// Function to redirect user to login page if not logged in
function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function displayPosts() {// Function to display all posts
    global $conn;// Access the global database connection object
    $query = "SELECT * FROM posts";// SQL query to select all posts
    $result = mysqli_query($conn, $query);// Execute the query
    while ($row = mysqli_fetch_assoc($result)) {// Loop through each row in the result set
        echo "<div>";
        echo "<h3>" . $row['title'] . "</h3>";// Display post title
        echo "<p>" . $row['content'] . "</p>";// Display post content
        echo "</div>";
    }
}

function authenticateUser($username, $password) {
    global $conn;
    $username = sanitize($username);// Sanitize username
    $password = sanitize($password);// Sanitize password
       // SQL query to select user with the provided username
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {// Check if any row is returned
        $user = mysqli_fetch_assoc($result);// Fetch the user data
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];// Set 'user_id' session variable
            $_SESSION['username'] = $user['username'];
            // Return true if authentication is successful
            return true;
        }
    }
    return false;
}

function registerUser($username, $password) {
    global $conn;
    $username = sanitize($username);
    $password = sanitize($password);
   // Hash the password before storing in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // SQL query to insert new user into the database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
    return mysqli_query($conn, $query);// Execute the query and return true/false based on success
}
?>
