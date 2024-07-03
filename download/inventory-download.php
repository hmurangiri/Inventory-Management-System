<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once '../db/config.php';

$sql = "SELECT Product, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Purchase' THEN ov.Quantity ELSE 0 END) AS `Stock Bought`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Sale' THEN ov.Quantity ELSE 0 END) AS `Stock Sold`, ";
$sql .= "SUM((CASE WHEN Ordertype = 'Purchase' THEN ov.Quantity ELSE 0 END) - (CASE WHEN Ordertype = 'Sale' THEN ov.Quantity ELSE 0 END)) AS `Remaining Stock`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Sale' THEN TotalSales ELSE 0 END) AS `Total Purchases`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Purchase' THEN TotalPurchases ELSE 0 END) AS `Total Sales`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Sale' THEN (Sellingprice * ov.Quantity) - (Buyingprice * ov.Quantity) ELSE 0 END) AS Profit, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Purchase' THEN (pp.Remaining * pp.BPrice) ELSE 0 END) AS `Remaining Stock Value` ";
$sql .= "FROM OrdersView ov ";
$sql .= "LEFT JOIN purchases pp ";
$sql .= "ON pp.PurchaseID = ov.ID ";
$sql .= "WHERE ov.StoreID = " . $_SESSION['store_id'];
$sql .= " GROUP BY ov.ProductID ";

// $sql = "SELECT ID, ProductID, Product, Quantity, Buyingprice, TotalPurchases, TIME AS Time, User ";
// $sql .= "FROM OrdersView ";
// $sql .= "WHERE Ordertype = 'Purchase' ";
// $sql .= "AND StoreID = " . $_SESSION['store_id'];

$result = $conn->query($sql);
$conn->close();

if ($result->num_rows > 0) {
    // Set CSV file headers
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"inventory.csv\"");

    // Open output stream
    $output = fopen("php://output", "w");

    // Write CSV headers
    fputcsv($output, array("Product", "Stock Bought", "Stock Sold", "Remaining Stock", "Total Purchases", "Total Sales", "Profit", "Remaining Stock Value"));

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