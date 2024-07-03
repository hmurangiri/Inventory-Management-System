<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once "../db/config.php";

$ordertype_name = htmlspecialchars($_POST['ordertype-name']);

$sql = "INSERT INTO ordertypes (Name) VALUES (?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ordertype_name); 

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the "Create Category" page with a success message
    $stmt->close();
    $conn->close();
    header("Location: create-ordertype.php?message=Ordertype added successfully");
    exit();
} else {
    // Redirect back to the "Create Category" page with an error message
    $stmt->close();
    $conn->close();
    header("Location: create-ordertype.php?message=Error: An error was encountered when creating the order type");
    exit();
}
?>