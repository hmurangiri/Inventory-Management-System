<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $product_name = htmlspecialchars($_POST['product-name']);
    $category_selection = htmlspecialchars($_POST['category-selection']);
    $product_desc = htmlspecialchars($_POST['product-desc']);
    $product_id = htmlspecialchars($_POST['product_id']);

    $sql = "UPDATE products SET Name = ?, Description = ?, CategoryID = ? ";
    $sql .= "WHERE ProductID = ? AND StoreID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $product_name, $product_desc, $category_selection, $product_id, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: edit-product.php?message=Product edited successfully");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: edit-product.php?message=Error: An error was encountered!");
        exit();
    }
}
?>