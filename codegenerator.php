<?php

// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to generate a random code
function generateRandomCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_length = strlen($characters);
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, $char_length - 1)];
    }

    return $code;
}

// Check if email is set and not empty in the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        // Retrieve email from form submission
        $email = $_POST['email'];

        // Create connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "loginassignment";

        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch email and surname from members table
        $sql = "SELECT surname FROM members WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a row was found
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $surname = $row['surname'];

            // Generate random code
            $code = generateRandomCode();

            // Insert code and email into resetpassword table
            $insert_sql = "INSERT INTO resetpassword (email, code) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ss", $email, $code);
            $insert_stmt->execute();
            $insert_stmt->close();

            try {
                // Create a new PHPMailer instance
                $mail = new PHPMailer(true);

                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'shedrackwambua40@gmail.com'; // SMTP username
                $mail->Password   = 'xxxxxxxxxx';   // SMTP password
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                //Recipients
                $mail->setFrom('shedrackwambua40@gmail.com', 'RACK');
                $mail->addAddress($email, $surname);

                // Content
                $mail->isHTML(true);  // Set email format to HTML
                $mail->Subject = 'Password Reset Code';
                $mail->Body    = 'Your password reset code is: ' . $code;

                // Send email
                $mail->send();
                echo 'Message has been sent';

                // Redirect to entercode.php
                header("Location: entercode.php");
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Email not found in members table";
        }

        // Close connection
        $conn->close();
    } else {
        echo "Email not specified";
    }
}

?>
