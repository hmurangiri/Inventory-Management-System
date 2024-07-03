<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $supplier_name = htmlspecialchars($_POST['supplier-name']);
    $supplier_address = htmlspecialchars($_POST['supplier-address']);
    $supplier_contact = htmlspecialchars($_POST['supplier-contact']);

    $sql = "INSERT INTO suppliers (Name, ContactInfo, Address, StoreID) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $supplier_name, $supplier_contact, $supplier_address, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: create-supplier.php?message=Supplier added successfully");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: create-supplier.php?message=Error: An error was encountered when creating the supplier!");
        exit();
    }
}
?>