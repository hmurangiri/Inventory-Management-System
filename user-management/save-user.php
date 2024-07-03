<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $loc . "../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $user_fname = htmlspecialchars($_POST['user-fname']);
    $user_sname = htmlspecialchars($_POST['user-sname']);
    $user_email = htmlspecialchars($_POST['user-email']);
    $user_password = htmlspecialchars($_POST['user-password']);
    $user_role = htmlspecialchars($_POST['user-role-selection']);

    function isEmailAvailable($email, $conn)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows === 0;
    }

    function getUSerID($email, $conn)
    {
        $sql = "SELECT UserID FROM users WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $result = $row["UserID"];
        return $result;
    }

    if (!isEmailAvailable($user_email, $conn)) {
        $conn->close();
        header("Location: create-user.php?message=Error: Email already used!");
        exit();
    }

    function validatePassword($password)
    {
        // Minimum length of 8 characters
        if (strlen($password) < 8) {
            return false;
        }

        // At least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        // At least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }

        // At least one digit
        if (!preg_match('/\d/', $password)) {
            return false;
        }

        // Password meets all requirements
        return true;
    }

    if (!validatePassword($user_password)) {
        $conn->close();
        header("Location: create-user.php?message=Password does not meet the requirements! It should be atleast 8 characters, contain uppercase, lowercase and a digit!");
    }

    $sql = "INSERT INTO users (Firstname, Secondname, Email, Password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_fname, $user_sname, $user_email, $user_password);

    // Execute the query
    if ($stmt->execute()) {
        $stmt->close();

        $user_id = getUSerID($user_email, $conn);
        $sql = "INSERT INTO store_users (StoreID, UserID, UserRoleID) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $_SESSION['store_id'], $user_id, $user_role);
        $stmt->execute();

        $conn->close();
        header("Location: create-user.php?message=User added successfully. You can now login!");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        header("Location: signup.php?message=Error: An error was encountered");
        exit();
    }
}

?>