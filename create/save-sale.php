<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $ordertype_selection = 2;
    $product_selection = htmlspecialchars($_POST['product-selection']);
    $price = htmlspecialchars($_POST['price']);
    $quantity = htmlspecialchars($_POST['quantity']);

    if (!empty($_POST['customer-selection'])) {
        $customer_selection = htmlspecialchars($_POST['customer-selection']);
    }

    // $sql = "SELECT SUM(Remaining) FROM orders WHERE StoreID = ? AND OrdertypeID = 1 AND ProductID = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("ii", $_SESSION['store_id'], $product_selection);
    // $stmt->execute();
    // $stmt->bind_result($stocks);
    // $stmt->fetch();
    // $stmt->close();

    $sql = "SELECT SUM(Remaining) FROM purchases WHERE StoreID = ? AND ProductID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_SESSION['store_id'], $product_selection);
    $stmt->execute();
    $stmt->bind_result($stocks);
    $stmt->fetch();
    $stmt->close();
    
    if (isset($_POST['salesline'])) {
        $salesline = htmlspecialchars($_POST['salesline']);
    } else {
        $sql = "SELECT (SalesLine + 1) FROM sales ORDER BY SaleID DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($salesline);
        $stmt->fetch();
        $stmt->close();
    }

    if ($stocks >= $quantity) {
        // $sql = "SELECT OrderID, OrdertypeID, ProductID, BPrice, Remaining FROM orders ";
        // $sql .= "WHERE OrdertypeID = 1 AND Remaining > 0 AND StoreID = " . $_SESSION['store_id'] . " AND ProductID = " . $product_selection . " ";
        // $sql .= "ORDER BY Timestamp ASC";
        // $result = $conn->query($sql);

        $sql = "SELECT PurchaseID, ProductID, BPrice, Remaining FROM purchases ";
        $sql .= "WHERE Remaining > 0 AND StoreID = " . $_SESSION['store_id'] . " AND ProductID = " . $product_selection . " ";
        $sql .= "ORDER BY Time ASC";
        $result = $conn->query($sql);

        $stockCount = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stockCount += $row["Remaining"];
                if ($stockCount >= $quantity) {
                    $new_stock = $row["Remaining"] - $stockCount + $quantity;

                    // $sql2 = "UPDATE orders SET Remaining = " . ($stockCount - $quantity) . " WHERE OrderID = " . $row["OrderID"];
                    $sql2 = "UPDATE purchases SET Remaining = " . ($stockCount - $quantity) . " WHERE PurchaseID = " . $row["PurchaseID"];
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute();
                    $stmt2->close();

                    // $sql2 = "SELECT BPrice FROM orders WHERE OrderID = " . $row["OrderID"];
                    $sql2 = "SELECT BPrice FROM purchases WHERE PurchaseID = " . $row["PurchaseID"];
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    $buying_price = $row2["BPrice"];
                    $result2->free();

                    // $sql3 = "INSERT INTO orders (OrdertypeID, ProductID, BPrice, SPrice, Quantity, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $sql3 = "INSERT INTO sales (SalesLine, PurchaseID, ProductID, BPrice, SPrice, Quantity, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    if (!empty($_POST['customer-selection'])) {
                        $sql3 = "INSERT INTO sales (SalesLine, PurchaseID, CustomerID, ProductID, BPrice, SPrice, Quantity, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    }

                    $stmt3 = $conn->prepare($sql3);
                    if (!empty($_POST['customer-selection'])) {
                        $stmt3->bind_param("iiiiiddii", $salesline, $row["PurchaseID"], $customer_selection, $product_selection, $buying_price, $price, $new_stock, $_SESSION['user_id'], $_SESSION['store_id']);
                    } else {
                        $stmt3->bind_param("iiiiddii", $salesline, $row["PurchaseID"], $product_selection, $buying_price, $price, $new_stock, $_SESSION['user_id'], $_SESSION['store_id']);
                    }

                    $stmt3->execute();
                    $stmt3->close();
                    break;
                } else {
                    // $sql2 = "UPDATE orders SET Remaining = 0 WHERE OrderID = " . $row["OrderID"];
                    $sql2 = "UPDATE purchases SET Remaining = 0 WHERE PurchaseID = " . $row["PurchaseID"];
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute();
                    $stmt2->close();

                    // $sql2 = "SELECT BPrice FROM orders WHERE OrderID = " . $row["OrderID"];
                    $sql2 = "SELECT BPrice FROM purchases WHERE PurchaseID = " . $row["PurchaseID"];
                    $result2 = $conn->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    $buying_price = $row2["BPrice"];
                    $result2->free();

                    // $sql3 = "INSERT INTO orders (OrdertypeID, ProductID, BPrice, SPrice, Quantity, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $sql3 = "INSERT INTO sales (SalesLine, PurchaseID, ProductID, BPrice, SPrice, Quantity, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                    if (!empty($_POST['customer-selection'])) {
                        $sql3 = "INSERT INTO sales (SalesLine, PurchaseID, CustomerID, ProductID, BPrice, SPrice, Quantity, UserID, StoreID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    }

                    $stmt3 = $conn->prepare($sql3);
                    if (!empty($_POST['customer-selection'])) {
                        $stmt3->bind_param("iiiiddiii", $salesline, $row["PurchaseID"], $customer_selection, $product_selection, $buying_price, $price, $row["Remaining"], $_SESSION['user_id'], $_SESSION['store_id']);
                    } else {
                        $stmt3->bind_param("iiiddiii", $salesline, $row["PurchaseID"], $product_selection, $buying_price, $price, $row["Remaining"], $_SESSION['user_id'], $_SESSION['store_id']);
                    }

                    $stmt3->execute();
                    $stmt3->close();
                }
            }

            $conn->close();
            header("Location: create-sale.php?message=Success: The sale was recorded successfully");
            exit();

        } else {
            $conn->close();
            header("Location: create-sale.php?message=Error: The query encountered an error");
            exit();
        }
    } else {
        $conn->close();
        header("Location: create-sale.php?message=Error: The remaining stock is less than the requested quantities");
        exit();
    }
} else {
    $conn->close();
    header("Location: create-sale.php");
    exit();
}