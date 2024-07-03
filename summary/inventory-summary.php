<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Inventory';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';
include_once '../db/config.php';

$sql = "SELECT Product, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Purchase' THEN ov.Quantity ELSE 0 END) AS `Stock Bought`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Sale' THEN ov.Quantity ELSE 0 END) AS `Stock Sold`, ";
$sql .= "SUM((CASE WHEN Ordertype = 'Purchase' THEN ov.Quantity ELSE 0 END) - (CASE WHEN Ordertype = 'Sale' THEN ov.Quantity ELSE 0 END)) AS `Remaining Stock`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Sale' THEN TotalSales ELSE 0 END) AS `Total Purchases`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Purchase' THEN TotalPurchases ELSE 0 END) AS `Total Sales`, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Sale' THEN (Sellingprice * ov.Quantity) - (Buyingprice * ov.Quantity) ELSE 0 END) AS Profit, ";
$sql .= "SUM(CASE WHEN Ordertype = 'Purchase' THEN (pp.Remaining * pp.BPrice) ELSE 0 END) AS `Remaining Stock Value` ";
$sql .= "FROM OrdersView ov ";
$sql .= "LEFT JOIN purchases pp ";
$sql .= "ON pp.PurchaseID = ov.ID ";
$sql .= "WHERE ov.StoreID = " . $_SESSION['store_id'];
$sql .= " GROUP BY ov.ProductID ";

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
                        Inventory
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
            <div><label><input type=checkbox name=product checked onchange='sel()'>Product</label></div>
            <div><label><input type=checkbox name=stockbought checked onchange='sel()'>Stock Bought</label></div>
            <div><label><input type=checkbox name=stocksold checked onchange='sel()'>Stock Sold<label></div>
            <div><label><input type=checkbox name=remainingstock checked onchange='sel()'>Remaining Stock<label></div>
            <div><label><input type=checkbox name=totalpurchases checked onchange='sel()'>Stock Purchase<label></div>
            <div><label><input type=checkbox name=totalsales checked onchange='sel()'>Total Sales<label></div>
            <div><label><input type=checkbox name=profit checked onchange='sel()'>Profit<label></div>
            <div><label><input type=checkbox name=remainingstockvalue checked onchange='sel()'>Remaining Stock Value<label></div>
        </fieldset>
    </div>
    <!--<div>-->

    <div class="table-reponsive box">
        <table class="table table-striped table-bordered" data-toggle="table" data-show-toggle="true"
            data-show-columns="true" data-search="true" data-striped="true">
            <colgroup>
                <col style="width:10%;">
                <col style="width:10%;">
                <col style="width:10%;">
                <col style="width:10%;">
                <col style="width:20%;">
                <col style="width:2%;">
                <col style="width:28%;">
                <col style="width:28%;">
            </colgroup>
            <thead>
                <tr>
                    <th data-field="product" onclick=tsort3(0); ondblclick=tsort2(0);>Product</th>
                    <th data-field="stockbought" onclick=tsort2(1);>Stock Bought</th>
                    <th data-field="stocksold" onclick=tsort2(1);>Stock Sold</th>
                    <th data-field="remainingstock" onclick=tsort(2);>Remaining Stock </th>
                    <th data-field="totalpurchases" onclick=tsort(2);>Stock Purchase</th>
                    <th data-field="totalsales" onclick=tsort(2);>Total Sales</th>
                    <th data-field="profit" onclick=tsort(2);>Profit</th>
                    <th data-field="remainingstockvalue" onclick=tsort(2);>Remaining Stock Value</th>
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
                        echo "<td>" . $row["Product"] . "</td>";
                        echo "<td>" . number_format($row["Stock Bought"]) . "</td>";
                        echo "<td>" . number_format($row["Stock Sold"]) . "</td>";
                        echo "<td>" . number_format($row["Remaining Stock"]) . "</td>";
                        echo "<td>" . number_format($row["Total Purchases"]) . "</td>";
                        echo "<td>" . number_format($row["Total Sales"]) . "</td>";
                        echo "<td>" . number_format($row["Profit"]) . "</td>";
                        echo "<td>" . number_format($row["Remaining Stock Value"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No inventory found</td></tr>";
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