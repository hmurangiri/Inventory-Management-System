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
    $order_id = htmlspecialchars($_POST['order_id']);
    $supplier_selection = null;

    if (!empty($_POST['customer-selection'])) {
        $customer_selection = htmlspecialchars($_POST['customer-selection']);
        $sql = "UPDATE sales SET CustomerID = " . $customer_selection . ", ProductID = " . $product_selection . ", ";
    } else {
        $sql = "UPDATE sales SET CustomerID = NULL, ProductID = " . $product_selection . ", ";
    }
    $sql .= "SPrice = " . $price . " WHERE SalesLine = " . $order_id;

    $conn->query($sql);

    $sql = "SELECT SUM(Quantity) FROM sales WHERE SalesLine = ? AND StoreID = ? GROUP BY SalesLine";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $_SESSION['store_id']);
    $stmt->execute();
    $stmt->bind_result($quantity2);

    if ($stmt->fetch()) {
        if ($quantity > $quantity2) {
            $stmt->close(); ?>

            <form style="display:none;" method="post" action="../create/save-sale.php">
                <input type="text" name="customer-selection" value="<?= $customer_selection ?>">
                <input type="text" name="product-selection" value="<?= $product_selection ?>">
                <input type="number" name="price" value="<?= $price ?>">
                <input type="number" name="quantity" value="<?= ($quantity - $quantity2) ?>">
                <input type="number" name="salesline" value="<?= $order_id ?>">
                <button type="submit" id="submit" class="btn btn-primary btn-block"></button>
            </form>

            <script>
                document.getElementById("submit").click();
            </script>

            <?php
        } elseif ($quantity == $quantity2) {
            $conn->close();
            header("Location: edit-sale.php?message=Edit done successfully");
            exit();
        } elseif ($quantity < 0) {
            $conn->close();
            header("Location: edit-sale.php?message=The quantity cannot be negative");
            exit();
        } else {
            $stmt->close();
            
            $sql = "SELECT SaleID, PurchaseID, Quantity FROM sales WHERE SalesLine = " . $order_id . " AND StoreID = " . $_SESSION['store_id'] . " ORDER BY SaleID DESC";
            $result = $conn->query($sql);
            $change = $quantity2 - $quantity;
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $sql2 = "UPDATE purchases SET Remaining = Remaining + " . $change . " WHERE PurchaseID = " . $row['PurchaseID'] . " AND StoreID = " . $_SESSION['store_id'] . "; ";
                    $conn->query($sql2);
                    if ($change >= $row['Quantity']) {
                        $sql2 = "DELETE FROM sales WHERE SaleID = " . $row['SaleID'] . "; ";
                        $conn->query($sql2);

                        $change = $change - $row['Quantity'];
                        if ($change == 0)
                            break;
                    } else {
                        $sql2 = "UPDATE sales SET Quantity = " . ($row['Quantity'] - $change) . " WHERE SaleID = " . $row['SaleID'] . " AND StoreID = " . $_SESSION['store_id'] . "; ";
                        $conn->query($sql2);
                        break;
                    }


                    // if ($conn->multi_query($sql2)) {
                    //     do {
                    //         if ($result2 = $conn->store_result()) {
                    //             $result2->free();
                    //         }
                    //     } while ($conn->more_results() && $conn->next_result());
                    // }
                }
            }
        }
        $conn->close();
        header("Location: edit-sale.php?message=Sale editted successfully");
        exit();
    } else {

    }

    // $sql = "UPDATE orders SET OrdertypeID = ?, CustomerID = ?, SupplierId = ?, ProductID = ?, Price = ?, Quantity = ? ";
    // $sql .= "WHERE OrderID = ? AND StoreID = ?";

    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("iiiidiii", $ordertype_selection, $customer_selection, $supplier_selection, $product_selection, $price, $quantity, $order_id, $_SESSION['store_id']);

    // Execute the query
    // if ($stmt->execute()) {
    //     // Redirect back to the "Create Category" page with a success message
    //     $stmt->close();
    //     $conn->close();
    //     header("Location: edit-sale.php?message=Order added successfully");
    //     exit();
    // } else {
    //     // Redirect back to the "Create Category" page with an error message
    //     $stmt->close();
    //     $conn->close();
    //     header("Location: edit-sale.php?message=Error: An error was encountered!");
    //     exit();
    // }
}
?>