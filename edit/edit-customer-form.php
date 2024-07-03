<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Edit Customer';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

$customer_id = $_GET['id'];
$sql = "SELECT CustomerID, Name, ContactInfo, Address FROM customers WHERE CustomerID = ? AND StoreID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $customer_id, $_SESSION['store_id']);
$stmt->execute();

$result = $stmt->get_result();
$customer = $result->fetch_assoc();
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
                        Customer Edit
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" action="edit-customer-response.php">
                
                <input type="hidden" name="customer_id" value="<?php echo $customer['CustomerID']; ?>">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="customer-name" id="customer-name" value="<?php echo $customer['Name']; ?>"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Address</label>
                            <input type="text" name="customer-address" id="customer-address" value="<?php echo $customer['Address']; ?>"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Contact Info</label>
                            <textarea id="customer-contact" class="form-control" name="customer-contact"
                                ><?php echo $customer['ContactInfo']; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Save
                            Customer Changes</button>
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