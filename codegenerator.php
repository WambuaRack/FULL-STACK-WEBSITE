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

// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

// Function to generate a random code
function generateRandomCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $char_length = strlen($characters);
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, $char_length - 1)];
    }

    return $code;
} // Moved closing brace here

// Check if email is set and not empty in the form submission
if (isset($_POST['email']) && !empty($_POST['email'])) {
    // Retrieve email from form submission
    $email = $_POST['email'];

    // Fetch email and surname from members table
    $sql = "SELECT email, surname FROM members WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a row was found
    if ($stmt->num_rows > 0) {
        // Bind results
        $stmt->bind_result($email, $surname);
        $stmt->fetch();

        // Generate random code
        $code = generateRandomCode();

        // Insert code and email into resetpassword table
        $insert_sql = "INSERT INTO resetpassword (email, code) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ss", $email, $code);
        $insert_stmt->execute();
        $insert_stmt->close();

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your@gmail.com'; // SMTP username
            $mail->Password   = '***************';   // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('your@gmail.com', 'RACK');
            $mail->addAddress($email, $surname);

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = 'Test E';
            $mail->Body    = $code;

            // Send email
            $mail->send();
            echo 'Message has been sent';

            header("location:entercode.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Email not found in members table";
    }
} else {
    echo "Email not specified";
}

?>
