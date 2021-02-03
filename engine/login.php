<?php

include "database.php";

if ($loggedin) header("Location: /");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$usnm = $_POST["username"];
	$pswd = $_POST["password"];

	header('Content-type: application/json');

	$sql = "SELECT id, password FROM `users` WHERE username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($usnm));
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);

  if (count($row) > 0 && password_verify($pswd, $row[0]->password))
    $_SESSION['user_id'] = $row[0]->id;
  else $message = "Wrong data.";

  echo json_encode(["message" => $message]);
	exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Log in</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1>Log in</h1>
	    <form id="login-form" action="/login" method="POST">
		    <input type="text" placeholder="Enter your username" name="username" /><br />
		    <input type="password" placeholder="and password" name="password" /><br />
		    <input type="submit" value="Submit" />
	    </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
