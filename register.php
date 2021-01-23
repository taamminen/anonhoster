<?php

session_start();
require "database.php";
if (isset($_SESSION["user_id"])) header("Location: /");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
	$stmt = $conn->prepare($sql);
	if ($stmt->execute([$_POST['username'], password_hash($_POST['password'], PASSWORD_BCRYPT])):
		header("Location: /");
	else echo('Sorry there must have been an issue creating your account.');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css" >
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css" >
</head>
<body>
    <main>

	    <form id="register-form" action="/register" method="POST">
		    <input type="text" placeholder="Enter your username" name="username">
		    <input type="password" placeholder="and password" name="password">
		    <input type="password" placeholder="confirm password" name="confirm_password">
		    <input type="submit" name="register-submit">
	    </form>

    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/bootstrap.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
