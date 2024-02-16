<?php
// Database connection parameters
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

// Check if the form is submitted
$selected_gender = "";
// Check if the form has been submitted
    // Check if gender is set in the POST data
    if (isset($_POST['gender'])) {
        // Get the selected gender value
   $selected_gender = $_POST['gender'];
        // Do something with the selected gender value, for example, store it in a database
        // You would replace this with your actual database insertion logic
        // For demonstration purposes, let's just echo it
    } 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $phone_no = $_POST['phone_no'];
    
    $selected_gender=$_POST['gender'];
// Here you can perform any further processing with the selected gender
        $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert data into the database
    $sql = "INSERT INTO members (first_name, surname, phone_no, gender, email, password) VALUES ('$first_name', '$surname', '$phone_no', '$selected_gender', '$email', '$hashed_password')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Details saved successfully";
        header("Location: login.php");
exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
