<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../db/config.php";

    $user_email = htmlspecialchars($_POST['user-email']);
    $user_password = htmlspecialchars($_POST['user-password']);

    $sql = "SELECT U.UserID, SU.UserRoleID, U.FirstName, U.SecondName FROM users U ";
    $sql .= "INNER JOIN store_users SU USING(UserID) ";
    $sql .= "WHERE U.Email = ? AND U.Password = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_email, $user_password);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt->close();
        $conn->close();
        header("Location: login.php?message=Error: The user does not exist");
        exit();
    } else {
        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['UserID'];
        $_SESSION['Firstname'] = $row['Firstname'];
        $_SESSION['Secondname'] = $row['Secondname'];
        $_SESSION['user_role'] = $row['UserRoleID'];

        $stmt->close();
        $sql = "SELECT S.StoreID, S.Name FROM stores S ";
        $sql .= "INNER JOIN store_users SU USING(StoreID) ";
        $sql .= "WHERE SU.UserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($result->num_rows === 0) {
            $stmt->close();
            $conn->close();
            header("Location: ../no-store");
            exit();
        } else {
            $_SESSION['store_id'] = $row['StoreID'];
            $_SESSION['store_name'] = $row['Name'];

            $stmt->close();
            $conn->close();
            header("Location: ../dashboard");
            exit();
        }
    }
}
?>