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

$sql3 = "SELECT SupplierID, Name FROM suppliers WHERE StoreID = " . $_SESSION['store_id'];
$result3 = $conn->query($sql3);

$sql4 = "SELECT ProductID, Name FROM products WHERE StoreID = " . $_SESSION['store_id'];
$result4 = $conn->query($sql4);

$order_id = $_GET['id'];
$sql5 = "SELECT PurchaseID, SupplierID, ProductID, BPrice, Quantity FROM purchases WHERE PurchaseID = ? AND StoreID = ?";
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
                        Edit Purchase
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap ">
            <form id="survey-form" method="post" action="edit-purchase-response.php">
                <div class="row">

                    <input type="hidden" name="order_id" value="<?php echo $order['PurchaseID']; ?>">

                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label id="ordertype-label" for="ordertype">Order Type</label>
                            <select id="ordertype-selection" name="ordertype-selection" class="form-control">
                                <option disabled selected value>Purchase</option>
                            </select>
                        </div>
                    </div> -->

                    <!-- <div class="col-md-6">
                        <div class="form-group">
                            <label id="customer-label" for="customer">Supplier</label>
                            <select id="supplier-selection" name="supplier-selection" class="form-control">
                                <option disabled selected value>Select</option>
                                <?php
                                // if ($result3->num_rows > 0) {
                                //     while ($row = $result3->fetch_assoc()) {
                                //         if ($row["SupplierID"] == $order["SupplierID"]) {
                                //             echo "<option value='" . $row["SupplierID"] . "' selected>" . $row["Name"] . "</option>";
                                //         } else {
                                //             echo "<option value='" . $row["SupplierID"] . "'>" . $row["Name"] . "</option>";
                                //         }
                                //     }
                                // }
                                ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="supplier-label" for="supplier">Supplier</label>
                            <select id="supplier-selection" name="supplier-selection" class="form-control">
                                <option disabled selected value>Select</option>
                                <?php
                                if ($result3->num_rows > 0) {
                                    while ($row = $result3->fetch_assoc()) {
                                        if ($row["SupplierID"] == $order["SupplierID"]) {
                                            echo "<option value='" . $row["SupplierID"] . "' selected>" . $row["Name"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["SupplierID"] . "'>" . $row["Name"] . "</option>";
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
                            <input type="number" name="price" id="price" value="<?php echo $order['BPrice']; ?>"
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