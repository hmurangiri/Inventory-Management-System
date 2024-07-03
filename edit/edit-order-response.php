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
    $order_id = htmlspecialchars($_POST['order_id']);

    if ($ordertype_selection == '1') {
        $customer_selection = NULL;
        $supplier_selection = htmlspecialchars($_POST['supplier-selection']);
    } else if ($ordertype_selection == '2') {
        $supplier_selection = NULL;
        $customer_selection = htmlspecialchars($_POST['customer-selection']);
    } else {
        $customer_selection = htmlspecialchars($_POST['customer-selection']);
        $supplier_selection = htmlspecialchars($_POST['supplier-selection']);
    }

    $sql = "INSERT INTO orders (OrdertypeID, CustomerID, SupplierID, ProductID, Price, Quantity) VALUES (?, ?, ?, ?, ?, ?)";
    $sql = "UPDATE orders SET OrdertypeID = ?, CustomerID = ?, SupplierId = ?, ProductID = ?, Price = ?, Quantity = ? ";
    $sql .= "WHERE OrderID = ? AND StoreID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiidiii", $ordertype_selection, $customer_selection, $supplier_selection, $product_selection, $price, $quantity, $order_id, $_SESSION['store_id']);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: edit-order.php?message=Order added successfully");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: edit-order.php?message=Error: An error was encountered!");
        exit();
    }
}
?>