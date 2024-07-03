<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $user_fname = htmlspecialchars($_POST['user-fname']);
    $user_sname = htmlspecialchars($_POST['user-sname']);
    $user_email = htmlspecialchars($_POST['user-email']);
    $user_password = htmlspecialchars($_POST['user-password']);
    $user_cpassword = htmlspecialchars($_POST['user-cpassword']);

    function isEmailAvailable($email, $conn) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows === 0;
    }

    if (!isEmailAvailable($user_email, $conn)) {
        $conn->close();
        header("Location: signup.php?message=Error: Email already used!");
        exit();
    } elseif ($user_cpassword != $user_password) {
        $conn->close();
        header("Location: signup.php?message=Error: Password and confirmation password do not match!");
        exit();
    }

    function validatePassword($password) {
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
        header("Location: signup.php?message=Password does not meet the requirements! It should be atleast 8 characters, contain uppercase, lowercase and a digit!");
    }

    $sql = "INSERT INTO users (Firstname, Secondname, Email, Password) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $user_fname, $user_sname, $user_email, $user_password);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the "Create Category" page with a success message
        $stmt->close();
        $conn->close();
        header("Location: login.php?message=User added successfully. You can now login!");
        exit();
    } else {
        // Redirect back to the "Create Category" page with an error message
        $stmt->close();
        $conn->close();
        header("Location: signup.php?message=Error: An error was encountered");
        exit();
    }
}
?>