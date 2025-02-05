<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once '../db/config.php';

$sql = "SELECT s.SaleID, s.ProductID, p.Name, s.Quantity, s.BPrice, s.SPrice, ";
$sql .= "(s.Quantity * s.SPrice) AS TotalSales, ((s.Quantity * s.SPrice) - (s.Quantity * s.BPrice)) AS Profit, s.Time, u.Email ";
$sql .= "FROM sales s ";
$sql .= "INNER JOIN products p ";
$sql .= "ON p.ProductID = s.ProductID ";
$sql .= "INNER JOIN users u ";
$sql .= "ON u.UserID = s.UserID ";
$sql .= "WHERE s.StoreID = " . $_SESSION['store_id'];
$result = $conn->query($sql);
$conn->close();

if ($result->num_rows > 0) {
    // Set CSV file headers
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"sales.csv\"");

    // Open output stream
    $output = fopen("php://output", "w");

    // Write CSV headers
    fputcsv($output, array("ID", "ProductID", "Product", "Quantity", "Buying Price", "Selling Price", "Total Sales", "Profit", "Time", "User"));

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