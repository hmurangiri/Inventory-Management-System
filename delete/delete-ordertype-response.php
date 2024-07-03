<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once('../db/config.php');
    $product_id = $_GET['id'];

    $sql = "DELETE FROM ordertypes WHERE OrdertypeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: delete-ordertype.php");
    exit();
}
?>