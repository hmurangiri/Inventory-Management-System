<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once('../db/config.php');
    $purchase_id = $_GET['id'];

    $sql = "DELETE FROM purchases WHERE PurchaseID = ? AND StoreID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $purchase_id, $_SESSION['store_id']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: delete-purchase.php");
    exit();
}
?>