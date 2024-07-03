<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $ordertype_selection = 1;
    $product_selection = htmlspecialchars($_POST['product-selection']);
    $price = htmlspecialchars($_POST['price']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $supplier_selection = htmlspecialchars($_POST['supplier-selection']);
    // $customer_selection = null;
    
    $supplier_selection = $supplier_selection !== '' ? $supplier_selection : NULL;

    $user = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    
    // $sql = "INSERT INTO orders (OrdertypeID, SupplierID, ProductID, BPrice, Quantity, Remaining, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $sql = "INSERT INTO purchases (SupplierID, ProductID, BPrice, Quantity, Remaining, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidiiii", $supplier_selection, $product_selection, $price, $quantity, $quantity, $_SESSION['user_id'], $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: create-purchase.php?message=Order added successfully");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: create-purchase.php?message=Error: The query encountered an error");
        exit();
    }
}
?>