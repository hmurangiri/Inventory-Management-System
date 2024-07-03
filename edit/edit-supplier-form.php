<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Edit Supplier';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

$supplier_id = $_GET['id'];
$sql = "SELECT SupplierID, Name, ContactInfo, Address FROM suppliers WHERE SupplierID = ? AND StoreID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $supplier_id, $_SESSION['store_id']);
$stmt->execute();

$result = $stmt->get_result();
$supplier = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1>
                    <hr> -->

                    <p id="description" class="text-center">
                        Supplier Edit
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" action="edit-supplier-response.php">

                <input type="hidden" name="supplier_id" value="<?php echo $supplier['SupplierID']; ?>">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="supplier-name" id="supplier-name" value="<?php echo $supplier['Name']; ?>"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Address</label>
                            <input type="text" name="supplier-address" id="supplier-address"
                            value="<?php echo $supplier['Address']; ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Contact Info</label>
                            <textarea id="supplier-contact" class="form-control" name="supplier-contact"
                                ><?php echo $supplier['ContactInfo']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Save
                            Supplier Changes</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

</div>

<?php

include '../utilities/inventory_footer.php'
    ?>
</body>

</html>