<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once "../db/config.php";

$customer_name = htmlspecialchars($_POST['customer-name']);
$customer_address = htmlspecialchars($_POST['customer-address']);
$customer_contact = htmlspecialchars($_POST['customer-contact']);
$customer_id = htmlspecialchars($_POST['customer_id']);

$sql = "UPDATE customers SET Name = ?, ContactInfo = ?, Address = ? ";
$sql .= "WHERE CustomerID = ? AND StoreID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssii", $customer_name, $customer_address, $customer_contact, $customer_id, $_SESSION['store_id']);

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the "Create Category" page with a success message
    $stmt->close();
    $conn->close();
    header("Location: edit-customer.php?message=Customer added successfully");
    exit();
} else {
    // Redirect back to the "Create Category" page with an error message
    $stmt->close();
    $conn->close();
    header("Location: edit-customer.php?message=Error: An error was encountered <br>");
    exit();
}
?>