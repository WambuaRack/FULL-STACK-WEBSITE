<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "loginassignment";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = $_POST['email'];
    $code = $_POST['code'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($email) || empty($code) || empty($new_password) || empty($confirm_password)) {
        header("Location: resetpassword.php?");
        echo "Empty fields!!";
        exit();
    } elseif ($new_password !== $confirm_password) {
        header("Location: resetpassword.php?");
        echo "Password mismatch";
        exit();
    }

    // Check if the code entered by the user matches the code stored in the resetpassword table
    $sql = "SELECT email FROM resetpassword WHERE email = ? AND code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Update password in the members table
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE members SET password = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $hashed_password, $email);
        if ($update_stmt->execute()) {
            // Password updated successfully
            header("Location: resetpassword.php?success=password_updated");
            exit();
            echo "PasswordUpdated";


            header("location:login.php");
        } else {
            // Error updating password
            header("Location: resetpassword.php?error=update_failed");


            exit();
        }
    } else {
        // Invalid verification code
        header("Location: resetpassword.php?error=invalid_code");
        echo "Invalid code";
        exit();
    }
} else {
    // Redirect to the reset password form
    header("Location: resetpassword.php");
    exit();
}

?>
