



<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="codegenerator.php">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send Reset Code</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>
</body>
</html>