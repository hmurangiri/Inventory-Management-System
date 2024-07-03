<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once "../db/config.php";

$customer_name = htmlspecialchars($_POST['customer-name']);
$customer_address= htmlspecialchars($_POST['customer-address']);
$customer_contact= htmlspecialchars($_POST['customer-contact']);

$sql = "INSERT INTO customers (Name, ContactInfo, Address, StoreID) VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $customer_name, $customer_contact, $customer_address, $_SESSION['store_id']); 

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the "Create Category" page with a success message
    $stmt->close();
    $conn->close();
    header("Location: create-customer.php?message=Customer added successfully");
    exit();
} else {
    // Redirect back to the "Create Category" page with an error message
    $stmt->close();
    $conn->close();
    header("Location: create-customer.php?message=Error: An error was encountered when creating the customer!");
    exit();
}
?>