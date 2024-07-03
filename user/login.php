<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">
    <link href="../css/styles2.css" rel="stylesheet">
</head>

<body>

    <div class="container content">

        <div class="row justify-content-center">
            <div class="col-12">
                <header class="header">
                    <div>
                        <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                        <p id="description" class="text-center">
                            Login
                        </p>
                    </div>
                </header>
            </div>


            <div class="form-wrap user-form" style="max-width:500px">
                <form id="survey-form" method="post" action="get-user.php">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="user-email-label" for="user-email">Email</label>
                                <input type="email" name="user-email" id="user-email" placeholder="Enter Email"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="user-password-label" for="user-password">Password</label>
                                <input type="password" name="user-password" id="user-password"
                                    placeholder="Enter Password" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 container text-center">
                            <button type="submit" id="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>

                <p class="text-center" style="margin: 20px 0 0 0;">Don't have an account? <a href="signup">Create Account</a></p>
            </div>
        </div>
    </div>

    </div>

    <?php
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