<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once('../db/config.php');
    $salesline_id = $_GET['id'];

    $sql = "UPDATE purchases p ";
    $sql .= "JOIN (SELECT PurchaseID, Quantity FROM sales WHERE SalesLine = ? AND StoreID = ?) ";
    $sql .= "s ON p.PurchaseID = s.PurchaseID ";
    $sql .= "SET p.Remaining = (p.Remaining + s.Quantity)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $salesline_id, $_SESSION['store_id']);
    $stmt->execute();
    $stmt->close();

    $sql = "DELETE FROM sales WHERE SalesLine = ? AND StoreID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $salesline_id, $_SESSION['store_id']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: delete-sale.php");
    exit();
}
?>