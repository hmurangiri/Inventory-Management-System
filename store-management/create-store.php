<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <link href="../css/styles2.css" rel="stylesheet">
    <title>Create Store</title>
</head>

<body>

    <div class="container content">

        <div class="row justify-content-center">
            <div class="col-12">
                <header class="header">
                    <div>
                        <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                        <p id="description" class="text-center">
                            Create A Store
                        </p>
                    </div>
                </header>
            </div>


            <div class="form-wrap ">
                <form id="survey-form" method="post" action="save-store.php">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="quantity-label" for="quantity">Store Name</label>
                                <input type="text" name="store-name" id="store-name" placeholder="Enter Name"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 container text-center">
                            <button type="submit" id="submit" class="btn btn-primary btn-block">Create
                                Store</button>
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

    ?>
</body>

</html>