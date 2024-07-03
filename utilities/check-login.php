<?php
function check_login_status($loc)
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . $loc . "user/login.php");
        exit();
    }
}
?>