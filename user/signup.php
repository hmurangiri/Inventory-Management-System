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
                            Sign Up
                        </p>
                    </div>
                </header>
            </div>


            <div class="form-wrap user-form">
                <form id="survey-form" method="post" action="save-user.php">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="user-fname-label" for="fname">First Name</label>
                                <input type="text" name="user-fname" id="user-fname" placeholder="Enter First Name"
                                    class="form-control" required>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="user-sname-label" for="user-sname">Second Name</label>
                                <input type="text" name="user-sname" id="user-sname" placeholder="Enter Second Name"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="user-email-label" for="user-email">Email</label>
                                <input type="email" name="user-email" id="user-email" placeholder="Enter Email"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="user-password-label" for="user-password">Password</label>
                                <input type="password" name="user-password" id="user-password"
                                    placeholder="Enter Password" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label id="user-cpassword-label" for="user-cpassword">Confirm Password</label>
                                <input type="password" name="user-cpassword" id="user-cpassword"
                                    placeholder="Repeat Password" class="form-control" required>
                            </div>
                        </div>
                        <div id="passwordMatch"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 container text-center">
                            <button type="submit" id="submit" class="btn btn-primary btn-block">Create
                                Account</button>
                        </div>
                    </div>
                </form>
                
                <p class="text-center" style="margin: 20px 0 0 0;">Do you have an account? <a href="login">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById("user-password");
        const confirmPasswordInput = document.getElementById("user-cpassword");
        const passwordMatchMessage = document.getElementById("passwordMatch");

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password === confirmPassword) {
                passwordMatchMessage.textContent = "Passwords match";
                passwordMatchMessage.style.color = "green";
            } else {
                passwordMatchMessage.textContent = "Passwords do not match";
                passwordMatchMessage.style.color = "red";
            }
        }

        confirmPasswordInput.addEventListener("input", checkPasswordMatch);
    </script>

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