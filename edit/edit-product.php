<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Edit Product';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';
include_once '../db/config.php';

$sql = "SELECT P.ProductID AS ID, P.Name AS Name, P.Description AS Descr, ";
$sql = $sql . "C.Name AS Category FROM products P ";
$sql = $sql . "INNER JOIN categories C ";
$sql = $sql . "ON P.CategoryID = C.CategoryID ";
$sql = $sql . "WHERE P.StoreID = " . $_SESSION['store_id'];
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
                        Edit Product
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
            <div><label><input type=checkbox name=name checked onchange='sel()'>Name</label></div>
            <div><label><input type=checkbox name=category checked onchange='sel()'>Category<label></div>
            <div><label><input type=checkbox name=desc checked onchange='sel()'>Description<label></div>
        </fieldset>
    </div>
    <!--<div>-->

    <div class="table-reponsive box">
        <table class="table table-striped table-bordered" data-toggle="table" data-show-toggle="true"
            data-show-columns="true" data-search="true" data-striped="true">
            <colgroup>
                <col style="width:2%;">
                <col style="width:30%;">
                <col style="width:20%;">
                <col style="width:48%;">
            </colgroup>
            <thead>
                <tr>
                    <th data-field="ID" onclick=tsort3(0); ondblclick=tsort2(0);>ID</th>
                    <th data-field="Name" onclick=tsort2(1);>Name</th>
                    <th data-field="Category" onclick=tsort(2);>Category</th>
                    <th data-field="Description" onclick=tsort(2);>Description</th>
                    <th data-field="Delete">Edit</th>
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
                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>" . $row["Category"] . "</td>";
                        echo "<td>" . $row["Descr"] . "</td>";
                        echo "<td><a href='edit-product-form.php?id=" . $row['ID'] . "'><i class='bx bx-edit' style='color:blue;'></i></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found</td></tr>";
                }
                ?>

            <tbody>
                <!-- <caption> Table Control Test</caption> -->
        </table>
    </div>
</div>
</div>

<script>
</script>

<?php

if (isset($_GET['message'])) {
    $msg = '<script>';
    $msg = $msg . 'setTimeout(function(){ alert("' . htmlspecialchars($_GET['message']) . '"); }, 1000);';
    $msg = $msg . '</script>';

    echo $msg;
}

include '../utilities/inventory_footer.php'
    ?>
</body>

</html>