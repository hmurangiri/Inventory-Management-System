<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once "../db/config.php";

$category_name = htmlspecialchars($_POST['category-name']);
$description = htmlspecialchars($_POST['category-desc']);

$sql = "INSERT INTO categories (Name, Description, StoreID) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $category_name, $description, $_SESSION['store_id']); 

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the "Create Category" page with a success message
    $stmt->close();
    $conn->close();
    header("Location: create-category.php?message=Category added successfully");
    exit();
} else {
    // Redirect back to the "Create Category" page with an error message
    $stmt->close();
    $conn->close();
    header("Location: create-category.php?message=Error: " . $sql . "<br>" . $conn->error);
    exit();
}
?>