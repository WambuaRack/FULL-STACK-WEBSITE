

<?php
// Assuming you have a database connection established

// Function to generate a random code
function generateRandomCode($length = 8) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

// Function to send an email
function sendEmail($to, $code) {
    $subject = 'Password Reset Code';
    $message = 'Your password reset code is: ' . $code;
    $headers = 'From: your@example.com' . "\r\n" .
               'Reply-To: your@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send email
    mail($to, $subject, $message, $headers);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user submitted a valid email
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];

        // Generate a random code
        $code = generateRandomCode();

        // Store the code in your database (you need to have a users table with a column for the reset code)
        // INSERT INTO users (email, reset_code) VALUES ('$email', '$code')

        // Send the email with the code
        sendEmail($email, $code);

        // Redirect the user to a page where they can enter the code and set a new password
        header("Location: reset_password.php");
        exit();
    } else {
        // Invalid email
        $error = "Please enter a valid email address.";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Code</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>
</body>
</html>