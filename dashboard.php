<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "user/login.php");
    exit();
}

$home = '';
$home2 = '';

$title = 'Dashboard';
$desc = '';
$keywords = '';

// $to_email = "hmurangiri@gmail.com";
// $subject = "Test Email";
// $body = "This is a test email.";

// // Send email
// if (mail($to_email, $subject, $body)) {
//     echo "Email sent successfully.";
// } else {
//     echo "Email delivery failed.";
// }

include 'utilities/inventory_menu.php';
?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-12">
            <header class="header">
                <div>
                    <!-- <h1 id="title" class="text-center" style="text-align:center;">DASHBOARD</h1> -->

                    <p id="description" class="text-center">DASHBOARD</p>
                    <hr class="dotted-hr">
                    </hr>
                </div>
            </header>
        </div>


        <!-- <div class="form-wrap ">
            <p>Hey There</p>
        </div> -->
    </div>
</div>

</div>

<?php
include 'utilities/inventory_footer.php'
    ?>
</body>

</html>