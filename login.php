<?php
session_start(); // Start session to store user data

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
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate if user exists
    $stmt = $conn->prepare("SELECT email, password FROM members WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password matches, redirect to home page
            $_SESSION['email'] = $email; // Store user's email in session
            header("Location: home.php");
            exit();
        } else {
            // Password does not match
            $error = "Invalid email or password";
        }
    } else {
        // User does not exist
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div><br>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div><br>
        <div>
            <button type="submit">Login</button>
        </div><br>
        <p class="error"><?php echo isset($error) ? $error : ''; ?></p>
    </form>
    <p>Don't have an account? <a href="sign.php">Sign up</a></p>
    <p><a href="forgotpassword.php">Forgot password?</a></p>
</div>
</body>
</html>
