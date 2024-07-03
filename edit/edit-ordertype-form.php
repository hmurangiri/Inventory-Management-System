<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Edit Order Type';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

$ordertype_id = $_GET['id'];
$sql = "SELECT OrdertypeID, Name FROM ordertypes WHERE OrdertypeID = ? AND StoreID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ordertype_id, $_SESSION['store_id']);
$stmt->execute();

$result = $stmt->get_result();
$ordertype = $result->fetch_assoc();
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
                        Order Type Edit
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" action="edit-ordertype-response.php">

                <input type="hidden" name="ordertype_id" value="<?php echo $ordertype['OrdertypeID']; ?>">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="ordertype-name" id="ordertype-name" value="<?php echo $ordertype['Name']; ?>"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Save
                            Ordertype Changes</button>
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
    $msg = $msg . 'setTimeout(function(){ alert("'. htmlspecialchars($_GET['message']). '"); }, 10);';
    $msg = $msg . '</script>';

    echo $msg;
}

include '../utilities/inventory_footer.php'
?>
</body>
</html>