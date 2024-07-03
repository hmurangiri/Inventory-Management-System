<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Sales Summary';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';
include_once '../db/config.php';

$sql = "SELECT ID, Ordertype, Customer, Product, Quantity, Buyingprice, Sellingprice, TotalSales, TIME AS Time, User FROM OrdersView ";
$sql .= "WHERE StoreID = " . $_SESSION['store_id'] . " ";
$sql .= "AND Ordertype = 'Sale'";

$result = $conn->query($sql);
$conn->close();
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                    <p id="description" class="text-center">
                        Orders
                    </p>
                </div>
            </header>
        </div>

        <input type=search name=search placeholder='Search' title='Enter after typing'><i
            class="fas fa-solid fa-magnifying-glass"></i>
    </div>

    <div id="table-toggle-button">Show Options</div>
    <!--<div >-->
    <div id="table-options-container">
        <fieldset id="table-options">
            <div><label><input type=checkbox name=id checked onchange='sel()'>ID</label></div>
            <div><label><input type=checkbox name=ordertype checked onchange='sel()'>OrderType</label></div>
            <div><label><input type=checkbox name=customer checked onchange='sel()'>Customer</label></div>
            <div><label><input type=checkbox name=product checked onchange='sel()'>Product<label></div>
            <div><label><input type=checkbox name=quantity checked onchange='sel()'>Quantity<label></div>
            <div><label><input type=checkbox name=buyingprice checked onchange='sel()'>Buying Price<label></div>
            <div><label><input type=checkbox name=sellingprice checked onchange='sel()'>Selling Price<label></div>
            <div><label><input type=checkbox name=totalsales checked onchange='sel()'>Total Sales<label></div>
            <div><label><input type=checkbox name=time checked onchange='sel()'>Time<label></div>
            <div><label><input type=checkbox name=user checked onchange='sel()'>User<label></div>
        </fieldset>
    </div>
    <!--<div>-->

    <div class="table-reponsive box">
        <table class="table table-striped table-bordered" data-toggle="table" data-show-toggle="true"
            data-show-columns="true" data-search="true" data-striped="true">
            <colgroup>
                <col style="width:2%;">
                <col style="width:14%;">
                <col style="width:10%;">
                <col style="width:10%;">
                <col style="width:10%;">
                <col style="width:2%;">
                <col style="width:13%;">
                <col style="width:20%;">
                <col style="width:18%;">
                <col style="width:18%;">
            </colgroup>
            <thead>
                <tr>
                    <th data-field="id" onclick=tsort3(0); ondblclick=tsort2(0);>ID</th>
                    <th data-field="ordertype" onclick=tsort2(1);>Order Type</th>
                    <th data-field="customer" onclick=tsort2(1);>Customer</th>
                    <th data-field="product" onclick=tsort(2);>Product</th>
                    <th data-field="quantity" onclick=tsort(2);>Quantity</th>
                    <th data-field="buyingprice" onclick=tsort(2);>Buying Price</th>
                    <th data-field="sellingprice" onclick=tsort(2);>Selling Price</th>
                    <th data-field="totalsales" onclick=tsort(2);>Total Sales</th>
                    <th data-field="time" onclick=tsort(2);>Time</th>
                    <th data-field="user" onclick=tsort(2);>User</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                            <td>0</td>
                            <td>Remaining Tasks for this app</td>
                            <td>of all the remaining tasks required to complete this app</td>
                        </tr> -->

                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["ID"] . "</td>";
                        echo "<td>" . $row["Ordertype"] . "</td>";
                        echo "<td>" . $row["Customer"] . "</td>";
                        echo "<td>" . $row["Product"] . "</td>";
                        echo "<td>" . number_format($row["Quantity"]) . "</td>";
                        echo "<td>" . number_format($row["Buyingprice"]) . "</td>";
                        echo "<td>" . number_format($row["Sellingprice"]) . "</td>";
                        echo "<td>" . number_format($row["TotalSales"]) . "</td>";
                        echo "<td>" . $row["Time"] . "</td>";
                        echo "<td>" . $row["User"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found</td></tr>";
                }
                ?>

            <tbody>
                <!-- <caption> Table Control Test</caption> -->
        </table>
    </div>
</div>
</div>

<?php
include '../utilities/inventory_footer.php'
    ?>
</body>

</html>