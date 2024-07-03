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
    $supplier_id = htmlspecialchars($_POST['supplier_id']);

    $sql = "UPDATE suppliers SET Name = ?, ContactInfo = ?, Address = ? ";
    $sql .= "WHERE SupplierID = ? AND StoreID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $supplier_name, $supplier_contact, $supplier_address, $supplier_id, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: edit-supplier.php?message=Supplier added successfully");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: edit-supplier.php?message=Error: An error was encountered!");
        exit();
    }
}
?>