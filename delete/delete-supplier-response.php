<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once('../db/config.php');
    $product_id = $_GET['id'];

    $sql = "DELETE FROM suppliers WHERE SupplierID = ? AND StoreID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $_SESSION['store_id']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: delete-supplier.php");
    exit();
}
?>