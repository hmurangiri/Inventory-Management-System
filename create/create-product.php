<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Create Product';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

$sql1 = "SELECT SupplierID, Name FROM suppliers WHERE StoreID = " . $_SESSION['store_id'];
$result1 = $conn->query($sql1);

$sql2 = "SELECT CategoryID, Name FROM categories WHERE StoreID = " . $_SESSION['store_id'];
$result2 = $conn->query($sql2);

$conn->close();
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                    <p id="description" class="text-center">
                        Create A Product
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap ">
            <form id="survey-form" method="post" action="save-product.php">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="product-name" id="product-name" placeholder="Enter product name"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="email-label" for="email">Category</label>
                            <select id="category-selection" name="category-selection" class="form-control" required>
                                <option disabled selected value>Select</option>
                                <?php
                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo "<option value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="product-desc" class="form-control" name="product-desc"
                                placeholder="Enter product description here..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Create
                            Product</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

</div>

<?php

// Display messages from save_category.php
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