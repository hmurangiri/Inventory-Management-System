<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $user_id = htmlspecialchars($_POST['user-selection']);
    $user_role = htmlspecialchars($_POST['user-role-selection']);

    $sql = "INSERT INTO store_users (StoreID, UserID, UserRoleID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $_SESSION['store_id'], $user_id, $user_role);

    $sql = "UPDATE store_users SET UserRoleID = ? WHERE UserID = ? AND StoreID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_role, $user_id, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: change-user-role.php?message=User role changed successfully.");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: change-user-role.php?message=Error: An error was encountered");
        exit();
    }
}