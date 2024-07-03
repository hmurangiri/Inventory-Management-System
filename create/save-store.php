<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $store_name = htmlspecialchars($_POST['store-name']);

    $sql = "INSERT INTO stores (Name, UserID) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $store_name, $_SESSION['user_id']);

    // Execute the query
    if ($stmt->execute()) {

        $sql = "SELECT * FROM stores WHERE UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $_SESSION['store_id'] = $row['StoreID'];
        $_SESSION['store_name'] = $row['Name'];
        $_SESSION['user_role'] = 1;

        $sql = "INSERT INTO store_users (StoreID, UserID, UserRoleID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $_SESSION['store_id'], $_SESSION['user_id'], $_SESSION['user_role']);
        $stmt->execute();

        $stmt->close();
        $conn->close();
        header("Location: ../dashboard");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: create-store.php?message=Error: An error occured while creating the store!");
        exit();
    }
}
?>