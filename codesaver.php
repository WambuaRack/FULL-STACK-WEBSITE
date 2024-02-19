<?php

$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "loginassignment"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $code = $_POST['code'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password matching
    if ($new_password !== $confirm_password) {
        echo "Error: New passwords do not match.";
        exit();
    }

    // Hash the new password (use appropriate hashing method)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Check if the code, new password, and email are set
    if (isset($code, $new_password, $confirm_password, $_POST['email'])) {
        // Retrieve email from the form
        $email = $_POST['email'];

        // Check if the code exists and is valid within the 5-minute window
        $sql = "SELECT code, created_at FROM resetpassword WHERE email = ? AND code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $code);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $created_at = strtotime($row['created_at']);
            $current_time = time();
            $time_difference = $current_time - $created_at;
            if ($time_difference <= 300) { // 5 minutes = 300 seconds
                // Update the password in the database
                $update_sql = "UPDATE members SET password = ? WHERE email = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $hashed_password, $email);
                if ($update_stmt->execute()) {
                    // Password updated successfully
                    echo "Password updated successfully.";
                    // Delete the row from resetpassword table
                    $delete_sql = "DELETE FROM resetpassword WHERE email = ?";
                    $delete_stmt = $conn->prepare($delete_sql);
                    $delete_stmt->bind_param("s", $email);
                    $delete_stmt->execute();
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "The verification code has expired. Please request a new one.";
            }
        } else {
            // Code verification failed
            echo "Invalid verification code.";
        }
    } else {
        // Required form fields are not set
        echo "Error: Required form fields are not set.";
    }

    // Redirect to login page after processing
    header("Location: login.php");
    exit();
}

?>
