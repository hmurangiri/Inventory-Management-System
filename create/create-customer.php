<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Create Category';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1>
                    <hr> -->

                    <p id="description" class="text-center">
                        Create A Customer
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" action="save-customer.php">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="customer-name" id="customer-name" placeholder="Enter customer name"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Address</label>
                            <input type="text" name="customer-address" id="customer-address" placeholder="Enter customer address"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Contact Info</label>
                            <textarea id="customer-contact" class="form-control" name="customer-contact"
                                placeholder="Enter Customer Contacts Here..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Create
                            Customer</button>
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
    $msg = $msg . 'setTimeout(function(){ alert("'. htmlspecialchars($_GET['message']). '"); }, 1000);';
    $msg = $msg . '</script>';

    echo $msg;
}

include '../utilities/inventory_footer.php'
?>
</body>
</html>