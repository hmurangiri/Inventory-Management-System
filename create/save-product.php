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

    $sql = "INSERT INTO products (Name, Description, CategoryID, StoreID) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $product_name, $product_desc, $category_selection, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: create-product.php?message=Product added successfully");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: create-product.php?message=Error: An error was encountered when creating the product!");
        exit();
    }
}
?>