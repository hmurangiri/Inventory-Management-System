<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Create User';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

$sql = "SELECT RoleID, Name FROM user_roles WHERE RoleID >= " . $_SESSION["user_role"];
$result = $conn->query($sql);

$conn->close();
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                    <p id="description" class="text-center">
                        Create User
                    </p>
                </div>
            </header>
        </div>

        <div class="form-wrap">
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
                            <input type="password" name="user-password" id="user-password" placeholder="Enter Password"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="email-label" for="email">Select User Role</label>
                            <select id="user-role-selection" name="user-role-selection" class="form-control" required>
                                <!-- <option disabled selected value>Select</option> -->
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["RoleID"] . "'>" . $row["Name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-4 container text-center">
                        <button type="submit" id="submit" class="btn btn-primary btn-block">Create
                            User</button>
                    </div>
                </div>
            </form>
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