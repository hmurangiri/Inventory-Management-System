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
    $order_id = htmlspecialchars($_POST['order_id']);

    // $customer_selection = null;
    $supplier_selection = $supplier_selection !== null ? $supplier_selection : null;

    $sql = "SELECT Quantity, Remaining FROM purchases WHERE PurchaseID = ? AND StoreID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $_SESSION['store_id']);
    $stmt->execute();
    $stmt->bind_result($quantity2, $remaining);

    if ($stmt->fetch()) {
        if ($quantity2 == $remaining) {
            $stmt->close();

            $sql = "UPDATE purchases SET SupplierId = ?, ProductID = ?, BPrice = ?, Quantity = ?, Remaining = ? ";
            $sql .= "WHERE PurchaseID = ? AND StoreID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iidiiii", $supplier_selection, $product_selection, $price, $quantity, $quantity, $order_id, $_SESSION['store_id']);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header("Location: edit-purchase.php?message=Order added successfully");
                exit();
            } else {
                $stmt->close();
                $conn->close();
                header("Location: edit-purchase.php?message=Error: An error was encountered!");
                exit();
            }
        } else {
            $stmt->close();
            $conn->close();
            header("Location: edit-purchase.php?message=Error: This purchase cannot be edited!");
            exit();
        }
    } else {
        $stmt->close();
        $conn->close();
        header("Location: edit-purchase.php?message=Error: An error was encountered!");
        exit();
    }
} else {
    header("Location: edit-purchase.php");
    exit();
}
?>