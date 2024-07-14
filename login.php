<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "park";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Static admin credentials
$adminUsername = "admin";
$adminPassword = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if entered credentials match static admin credentials
    if ($username === $adminUsername && $password === $adminPassword) {
        // Admin user, redirect to admin page
        header("Location: index.html");
        exit();
    } else {
        // Check regular user credentials in the database
        $sql = "SELECT id, username FROM userdata WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Regular user, redirect to user page
            header("Location: booking.html");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }
}

$conn->close();
?>
