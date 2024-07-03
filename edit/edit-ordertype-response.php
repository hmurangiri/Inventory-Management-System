<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once "../db/config.php";

$ordertype_name = htmlspecialchars($_POST['ordertype-name']);
$ordertype_id = htmlspecialchars($_POST['ordertype_id']);

$sql = "UPDATE ordertypes SET Name = ? ";
$sql .= "WHERE OrdertypeID = ? AND StoreID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $ordertype_name, $ordertype_id, $_SESSION['store_id']); 

// Execute the query
if ($stmt->execute()) {
    // Redirect back to the "Create Category" page with a success message
    $stmt->close();
    $conn->close();
    header("Location: edit-ordertype.php?message=Ordertype added successfully");
    exit();
} else {
    // Redirect back to the "Create Category" page with an error message
    $stmt->close();
    $conn->close();
    header("Location: edit-ordertype.php?message=Error: An error was encountered!");
    exit();
}
?>