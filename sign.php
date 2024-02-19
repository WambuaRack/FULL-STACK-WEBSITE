<?php
?>

<!DOCTYPE html>
<html>
<head>
    <title>signup PAGE</title>

<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>



<div class="container2">
    
    <div class="container">
    <content>
    <center>
        <div class="title">
        <label><h1>Welcome to Sign Up Page</h1></label><br><br></div>
  <form method="POST" action="signup.php">        <label>First name</label>
<input type="text" name="first name" required=""><br><br>
<label>Surname</label>
<input type="text" name="surname" required=""><br><br>
<label>Phone No.</label>
<input type="text" name="phone_no"><br><br>
 <label>
    <input type="radio" name="gender" value="male">
    Male
  </label>
  <label>
    <input type="radio" name="gender" value="female">
    Female
  </label>
  <label>
    <input type="radio" name="gender" value="other">
    Other
  </label><br><br>
<label>Email</label>
<input type="email" name="email"  placeholder="rackwambus@gmail.com" required=""><br><br>
<label>Password</label>
<input type="Password" name="password" required=""><br><br>
<div class = "button">
<input type="submit" value="Submit"></div><br><br>
 Have an account?<a href="Login.php  ">Login </a>

    </form>
</center>
</content>
</div>
</div>
</body>
</html>
