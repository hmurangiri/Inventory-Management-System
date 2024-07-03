<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Delete Customer';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';
include_once '../db/config.php';

$sql = "SELECT CustomerID, Name, Address, ContactInfo FROM customers WHERE StoreID = " . $_SESSION['store_id'];
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
                        Delete Customer
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
            <div><label><input type=checkbox name=type checked onchange='sel()'>ID</label></div>
            <div><label><input type=checkbox name=name checked onchange='sel()'>Name</label></div>
            <div><label><input type=checkbox name=address checked onchange='sel()'>Address<label></div>
            <div><label><input type=checkbox name=contact checked onchange='sel()'>Contact<label></div>
        </fieldset>
    </div>
    <!--<div>-->

    <div class="table-reponsive box">
        <table class="table table-striped table-bordered" data-toggle="table" data-show-toggle="true"
            data-show-columns="true" data-search="true" data-striped="true">
            <colgroup>
                <col style="width:2%;">
                <col style="width:20%;">
                <col style="width:30%;">
                <col style="width:48%;">
            </colgroup>
            <thead>
                <tr>
                    <th data-field="ID" onclick=tsort3(0); ondblclick=tsort2(0);>ID</th>
                    <th data-field="Name" onclick=tsort2(1);>Name</th>
                    <th data-field="Address" onclick=tsort(2);>Address</th>
                    <th data-field="Contact" onclick=tsort(2);>Contact</th>
                    <th data-field="Delete">Delete</th>
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
                        echo "<td>" . $row["CustomerID"] . "</td>";
                        echo "<td>" . $row["Name"] . "</td>";
                        echo "<td>" . $row["Address"] . "</td>";
                        echo "<td>" . $row["ContactInfo"] . "</td>";
                        echo "<td><a href='delete-customer-response.php?id=" . $row['CustomerID'] . "'><i class='bx bx-x' style='color:red;'></i></a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No customers found</td></tr>";
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