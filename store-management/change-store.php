<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";
    $store_id = htmlspecialchars($_POST['store-selection']);
    
    $sql = "SELECT Name FROM stores WHERE StoreID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $store_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();
    
    $store_name = $result['Name'];
    
    $stmt->close();
    $conn->close();
    
    $_SESSION['store_id'] = $store_id;
    $_SESSION['store_name'] = $store_name;
    header("Location: ../dashboard");
}
?>