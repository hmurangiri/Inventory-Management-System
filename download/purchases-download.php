<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once '../db/config.php';

$sql = "SELECT ID, ProductID, Product, Quantity, Buyingprice, TotalPurchases, TIME AS Time, User ";
$sql .= "FROM OrdersView ";
$sql .= "WHERE Ordertype = 'Purchase' ";
$sql .= "AND StoreID = " . $_SESSION['store_id'];
$result = $conn->query($sql);
$conn->close();

if ($result->num_rows > 0) {
    // Set CSV file headers
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"purchases.csv\"");

    // Open output stream
    $output = fopen("php://output", "w");

    // Write CSV headers
    fputcsv($output, array("ID", "ProductID", "Product", "Quantity", "Buying Price", "Total Purchases", "Time", "User"));

    // Write data rows
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    // Close output stream
    fclose($output);

    header("Location: ../dashboard");
    exit();
} else {
    header("Location: ../dashboard.php?message=Error: An error was encountered!");
    exit();
}
?>