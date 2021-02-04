<?php

include "database.php";

if (Funcs::checkLoginState($conn)) header("Location: /");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$usnm = $_POST["username"];
	$pswd = $_POST["password"];
	$cpswd = $_POST["confirm_password"];

	header('Content-type: application/json');

	if (!Funcs::checkCSRF($csrf, $_POST['csrf'])) {
		$message = "CSRF check failed.";
		echo json_encode(["message" => $message]);
		exit;
	}
	if ($pswd != $cpswd)
		$message .= "\nPasswords don't match.";
	if (strlen($pswd) > 16 || strlen($pswd) < 8)
		$message .= "\nPassword has to be more than 8 symbols and less than 16 symbols";
	if (strlen($usnm) > 16 || strlen($usnm) < 8)
	$message .= "\nUsername has to be more than 8 symbols and less than 16 symbols";

	$sql = "SELECT COUNT(*) AS num FROM `users` WHERE username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($usnm));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row["num"] > 0)
		$message .= "\nUsername already taken";

	if ($message != "") {
		echo json_encode(["message" => $message]);
		exit;
	}

	$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
	$stmt = $conn->prepare($sql);
	try {
		$stmt->execute([$usnm, password_hash($pswd, PASSWORD_BCRYPT)]);
	} catch (Exception $e) {
		$message = "Some error occured.";
	}
	echo json_encode(["message" => $message]);
	exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1>Register <a href="/">(home)</a></h1>
			<p>If you already have an account, you can <a href="/login">log in</a>.</p>
	    <form id="register-form" action="/register" method="POST">
		    <input type="text" placeholder="Enter your username" name="username" /><br />
		    <input type="password" placeholder="and password" name="password" /><br />
		    <input type="password" placeholder="confirm password" name="confirm_password" /><br />
				<input type="hidden" name="csrf" value="<?= $csrf ?>" />
		    <input type="submit" value="Submit" />
	    </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
