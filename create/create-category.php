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
                        Create A Category
                    </p>
                </div>
            </header>
        </div>


        <div class="form-wrap">
            <form id="survey-form" method="post" action="save-category.php">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label id="name-label" for="name">Name</label>
                            <input type="text" name="category-name" id="category-name" placeholder="Enter category name"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea id="category-desc" class="form-control" name="category-desc"
                                placeholder="Enter Category Description Here..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Create
                            Category</button>
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
    $msg = $msg . 'setTimeout(function(){ alert("' . htmlspecialchars($_GET['message']) . '"); }, 1000);';
    $msg = $msg . '</script>';

    echo $msg;
}

include '../utilities/inventory_footer.php'
    ?>
</body>

</html>