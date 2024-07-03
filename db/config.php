<?php
$servername = "servername"; // Your server name
$username = "user"; // Your database username
$password = "password"; // Your database password
$dbname = "database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
