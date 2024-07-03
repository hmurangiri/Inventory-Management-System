<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

include_once $home2 . 'db/config.php';

$sql1 = "SELECT S.StoreID AS StoreID, S.Name AS StoreName FROM users U ";
$sql1 .= "INNER JOIN store_users SU ON SU.UserID = U.UserID ";
$sql1 .= "INNER JOIN stores S ON S.StoreID = SU.StoreID ";
$sql1 .= "WHERE SU.UserID = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();

$result = $stmt->get_result();
$stmt->close();
// $conn->close();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?= $desc ?>">
    <meta name="keywords" content="<?= $keywords ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="<?= $home ?>css/styles2.css" rel="stylesheet">
    <title><?= $title ?></title>
    </Title>
    <style></style>
</head>

<body>

    <div class="sidebar">
        <div class="logo-details">

            <!-- <span class="logo_name">Menu</span> -->

            <div class="sideMenu menu-closed">
                <ul id="sideMenuButtons">

                    <li class="homeLink"><a href="<?= $home2 ?>dashboard">Home</a></li>
                    <div
                        style="border-bottom: 1px solid black;margin-top:-10px; margin-bottom:10px;padding-bottom:10px;">

                        <span style="padding: 0px 0px;"><a href="<?= $home2 ?>user/logout">Logout</a></span>

                        <!-- <span style="padding: 0px 0px; float:right;"><a href="#">Sign Up</a></span> -->
                    </div>
                    
                    <span id="select-store-label">Select Store: </span>
                    <form id="store-selection-form" action="<?= $home2 ?>stores-management/change-store.php" method="post">
                    <div class="select-store">
                        <select name="store-selection" id="store-selection">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        
                                        if ($row["StoreID"] == $_SESSION["store_id"]) {
                                            echo "<option selected value='" . $row["StoreID"] . "'>" . $row["StoreName"] . "</option>";
                                        } else {
                                            echo "<option value='" . $row["StoreID"] . "'>" . $row["StoreName"] . "</option>";
                                        }
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <input type="submit" style="display: none;" id="submitBtn">
                    </form>
                    
                    <?php if ($_SESSION['user_role'] <= 3) { ?>

                    <li class="3"><button class=""><i class="fas fa-solid fa-circle"></i>Create</button></li>
                    <ul class="list 3">
                        <li><a href="<?= $home2 ?>create/create-product">Create Product</a></li>
                        <li><a href="<?= $home2 ?>create/create-category">Create Category</a></li>
                        <li><a href="<?= $home2 ?>create/create-customer">Create Customer</a></li>
                        <li><a href="<?= $home2 ?>create/create-supplier">Create Supplier</a></li>
                        <li><a href="<?= $home2 ?>create/create-purchase">Create Purchase</a></li>
                        <li><a href="<?= $home2 ?>create/create-sale">Create Sale</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] <= 4) { ?>
                    
                    <li class="4"><button><i class="fas fa-solid fa-circle"></i>View</button></li>
                    <ul class="list 4">
                        <li><a href="<?= $home2 ?>view/categories">Categories</a></li>
                        <li><a href="<?= $home2 ?>view/customers">Customers</a></li>
                        <li><a href="<?= $home2 ?>view/suppliers">Suppliers</a></li>
                        <li><a href="<?= $home2 ?>view/products">Products</a></li>
                        <li><a href="<?= $home2 ?>view/ordertypes">Order Types</a></li>
                        <li><a href="<?= $home2 ?>view/purchases">Purchases</a></li>
                        <li><a href="<?= $home2 ?>view/sales">Sales</a></li>
                        <li><a href="<?= $home2 ?>view/orders">Orders</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] <= 3) { ?>
                    
                    <li class="3"><button><i class="fas fa-solid fa-circle"></i>Delete</button></li>
                    <ul class="list 3">
                        <li><a href="<?= $home2 ?>delete/delete-product">Delete Product</a></li>
                        <li><a href="<?= $home2 ?>delete/delete-category">Delete Category</a></li>
                        <li><a href="<?= $home2 ?>delete/delete-customer">Delete Customer</a></li>
                        <li><a href="<?= $home2 ?>delete/delete-supplier">Delete Supplier</a></li>
                        <li><a href="<?= $home2 ?>delete/delete-purchase">Delete Purchase</a></li>
                        <li><a href="<?= $home2 ?>delete/delete-sale">Delete Sale</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] <= 3) { ?>
                    
                    <li class="3"><button><i class="fas fa-solid fa-circle"></i>Edit</button></li>
                    <ul class="list 3">
                        <li><a href="<?= $home2 ?>edit/edit-category">Edit Category</a></li>
                        <li><a href="<?= $home2 ?>edit/edit-product">Edit Product</a></li>
                        <li><a href="<?= $home2 ?>edit/edit-customer">Edit Customer</a></li>
                        <li><a href="<?= $home2 ?>edit/edit-supplier">Edit Supplier</a></li>
                        <li><a href="<?= $home2 ?>edit/edit-ordertype">Edit Order Type</a></li>
                        <li><a href="<?= $home2 ?>edit/edit-purchase">Edit Purchase</a></li>
                        <li><a href="<?= $home2 ?>edit/edit-sale">Edit Sale</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] <= 4) { ?>
                    
                    <li class="4"><button><i class="fas fa-solid fa-circle"></i>Summary</button></li>
                    <ul class="list 4">
                        <li><a href="<?= $home2 ?>summary/sales-summary">Sales</a></li>
                        <li><a href="<?= $home2 ?>summary/purchases-summary">Purchases</a></li>
                        <li><a href="<?= $home2 ?>summary/inventory-summary">Inventory</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] == 1) { ?>
                    
                    <li class="1"><button><i class="fas fa-solid fa-circle"></i>Download</button></li>
                    <ul class="list 1">
                        <li><a href="<?= $home2 ?>download/sales-download">Sales</a></li>
                        <li><a href="<?= $home2 ?>download/purchases-download">Purchases</a></li>
                        <li><a href="<?= $home2 ?>download/inventory-download">Inventory</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] <= 3) { ?>
                    
                    <li class="3"><button><i class="fas fa-solid fa-circle"></i>Upload</button></li>
                    <ul class="list 3">
                        <li><a href="<?= $home2 ?>upload/import-product">Upload Products</a></li>
                        <li><a href="<?= $home2 ?>upload/import-product">Upload Categories</a></li>
                        <li><a href="<?= $home2 ?>upload/import-product">Upload Customers</a></li>
                        <li><a href="<?= $home2 ?>upload/import-product">Upload Suppliers</a></li>
                        <li><a href="<?= $home2 ?>upload/import-product">Upload Purchases</a></li>
                        <li><a href="<?= $home2 ?>upload/import-product">Upload Sales</a></li>
                    </ul>
                    
                    <?php } if ($_SESSION['user_role'] <= 2) { ?>
                    
                    <li class="1"><button><i class="fas fa-solid fa-circle"></i>Manage Users</button></li>
                    <ul class="list 1">
                        <li><a href="<?= $home2 ?>user-management/create-user">Create User</a></li>
                        <li><a href="<?= $home2 ?>user-management/change-user-role">Change Use Role</a></li>
                    </ul>
                    
                    
                    <?php } if ($_SESSION['user_role'] == 1) { ?>
                    
                    <li class="1"><button><i class="fas fa-solid fa-circle"></i>Manage Stores</button></li>
                    <ul class="list 1">
                        <li><a href="<?= $home2 ?>stores-management/create-store">Create Store</a></li>
                    </ul>
                    
                    <?php } ?>
                    
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var storeSelectElement = document.getElementById('store-selection');
            storeSelectElement.addEventListener('change', function() {
                document.getElementById('store-selection-form').submit();
            });
        });
    </script>

    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">
                <?php echo $_SESSION['store_name']; ?> Inventory Management
            </span>
            <hr>
            <div class="container content">

                <div class="row justify-content-center">
                    <!--<div class="col-12">-->
                    <!--    <header class="header">-->
                    <!--        <div>-->
                    <!--            <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1>-->

                    <!--            <p id="description" class="text-center">-->
                    <!--                Product Form-->
                    <!--            </p>-->
                    <!--        </div>-->
                    <!--    </header>-->
                    <!--</div>-->