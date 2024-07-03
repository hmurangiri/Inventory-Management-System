<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once "../db/config.php";

$category_name = htmlspecialchars($_POST['category-name']);
$description = htmlspecialchars($_POST['category-desc']);
$category_id = htmlspecialchars($_POST['category_id']);

$sql = "UPDATE categories SET Name = ?, Description = ? ";
$sql .= "WHERE CategoryID = ? AND StoreID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $category_name, $description, $category_id, $_SESSION['store_id']); 

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the "Create Category" page with a success message
    $stmt->close();
    $conn->close();
    header("Location: edit-category.php?message=Category edited successfully");
    exit();
} else {
    // Redirect back to the "Create Category" page with an error message
    $stmt->close();
    $conn->close();
    header("Location: edit-category.php?message=Error: An error was encountered!<br>");
    exit();
}
?>