<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Edit Order';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

// $sql1 = "SELECT OrdertypeID, Name FROM ordertypes";
// $result1 = $conn->query($sql1);

$sql2 = "SELECT CustomerID, Name FROM customers WHERE StoreID = " . $_SESSION['store_id'];
$result2 = $conn->query($sql2);

$sql4 = "SELECT ProductID, Name FROM products WHERE StoreID = " . $_SESSION['store_id'];
$result4 = $conn->query($sql4);

$order_id = $_GET['id'];
$sql5 = "SELECT SalesLine, CustomerID, ProductID, SPrice, SUM(Quantity) AS Quantity FROM sales ";
$sql5 .= "WHERE SalesLine = ? AND StoreID = ? GROUP BY SalesLine";
$stmt = $conn->prepare($sql5);
$stmt->bind_param("ii", $order_id, $_SESSION['store_id']);
$stmt->execute();
$result5 = $stmt->get_result();
$order = $result5->fetch_assoc();
$stmt->close();

$conn->close();
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                    <p id="description" class="text-center">
                        Edit Sale
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap ">
            <form id="survey-form" method="post" action="edit-sale-response.php">
                <div class="row">

                    <input type="hidden" name="order_id" value="<?php echo $order['SalesLine']; ?>">

                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label id="ordertype-label" for="ordertype">Order Type</label>
                            <select id="ordertype-selection" name="ordertype-selection" class="form-control">
                                <option disabled selected value>Sale</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="customer-label" for="customer">Customer</label>
                            <select id="customer-selection" name="customer-selection" class="form-control">
                                <option disabled selected value>Select</option>
                                <?php
                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        if ($row["CustomerID"] == $order["CustomerID"]) {
                                            echo "<option value='" . $row["CustomerID"] . "' selected>" . $row["Name"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["CustomerID"] . "'>" . $row["Name"] . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="product-label" for="product">Product</label>
                            <select id="product-selection" name="product-selection" class="form-control" required>
                                <option disabled selected value>Select</option>
                                <?php
                                if ($result4->num_rows > 0) {
                                    while ($row = $result4->fetch_assoc()) {
                                        if ($row["ProductID"] == $order["ProductID"]) {
                                            echo "<option value='" . $row["ProductID"] . "' selected>" . $row["Name"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["ProductID"] . "'>" . $row["Name"] . "</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="price-label" for="price">Price</label>
                            <input type="number" name="price" id="price" value="<?php echo $order['SPrice']; ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="quantity-label" for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="<?php echo $order['Quantity']; ?>"
                                class="form-control" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Save
                            Order Changes</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

</div>

<?php

if (isset($_GET['message'])) {
    $msg = '<script>';
    $msg = $msg . 'setTimeout(function(){ alert("' . htmlspecialchars($_GET['message']) . '"); }, 100);';
    $msg = $msg . '</script>';

    echo $msg;
}

include '../utilities/inventory_footer.php'
    ?>
</body>

</html>