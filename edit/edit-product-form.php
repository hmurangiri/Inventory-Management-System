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

$sql2 = "SELECT CategoryID, Name FROM categories";
$result2 = $conn->query($sql2);

$product_id = $_GET['id'];
$sql3 = "SELECT ProductID, Name, Description, CategoryID FROM products WHERE ProductID = ? AND StoreId = ?";
$stmt = $conn->prepare($sql3);
$stmt->bind_param("ii", $product_id, $_SESSION['store_id']);
$stmt->execute();
$result3 = $stmt->get_result(); 
$product = $result3->fetch_assoc();
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
                        Edit Product
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap ">
            <form id="survey-form" method="post" action="edit-product-response.php">
                
                <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="product-name" id="product-name" value="<?php echo $product['Name']; ?>"
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
                                        if ($row['CategoryID'] == $product['CategoryID']) {
                                            echo "<option value='" . $row["CategoryID"] . "' selected>" . $row["Name"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["CategoryID"] . "'>" . $row["Name"] . "</option>";
                                        }
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
                                ><?php echo $product['Description']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Save
                            Product Changes</button>
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