<?php
$servername = "localhost:3306"; // Your server name
$username = "skillswi_invent"; // Your database username
$password = "Testuser2023"; // Your database password
$dbname = "skillswi_inventory2"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>