<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $ordertype_selection = htmlspecialchars($_POST['ordertype-selection']);
    $product_selection = htmlspecialchars($_POST['product-selection']);
    $price = htmlspecialchars($_POST['price']);
    $quantity = htmlspecialchars($_POST['quantity']);
    
    $customer_selection = $customer_selection !== null ? $customer_selection : NULL;
    $supplier_selection = $supplier_selection !== null ? $supplier_selection : NULL;

    $sql = "INSERT INTO orders (OrdertypeID, CustomerID, SupplierID, ProductID, Price, Quantity, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiidii", $ordertype_selection, $customer_selection, $supplier_selection, $product_selection, $price, $quantity, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: create-order.php?message=Order added successfully");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: create-order.php?message=Error: " . $sql . "<br>" . $conn->error);
        exit();
    }
}
?>