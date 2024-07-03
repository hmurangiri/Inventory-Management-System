<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

$home = '../';
$home2 = '../';

$title = 'Change User Role';
$desc = '';
$keywords = '';

include '../utilities/inventory_menu.php';

include_once '../db/config.php';

$sql = "SELECT RoleID, Name FROM user_roles";
$result = $conn->query($sql);

$sql1 = "SELECT U.UserID AS UserID, U.FirstName AS FirstName, U.SecondName AS SecondName, U.Email AS Email FROM store_users SU ";
$sql1 .= "INNER JOIN users U ";
$sql1 .= "ON SU.UserID = U.UserID ";
$sql1 .= "WHERE SU.StoreID =  " . $_SESSION['store_id'] . " ";
$sql1 .= "ORDER BY FirstName, SecondName, Email ASC";
$stmt = $conn->prepare($sql1);
$result2 = $conn->query($sql1);

$conn->close();
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">Inventory Management</h1> -->

                    <p id="description" class="text-center">
                        Change User Role
                    </p>
                </div>
            </header>
        </div>

        <div class="form-wrap">
            <form id="survey-form" method="post" action="save-user-role-change.php">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="email-label" for="email">Select User</label>
                            <select id="user-selection" name="user-selection" class="form-control" required>
                                <!-- <option disabled selected value>Select</option> -->
                                <?php
                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo "<option value='" . $row["UserID"] . "'>" . $row["FirstName"] . " " . $row["SecondName"] . " - " . $row["Email"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
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