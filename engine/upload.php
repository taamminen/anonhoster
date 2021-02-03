<?php

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if ($loggedin) {
		$userid = $loggedin;
		$password = "";
	} else if (!empty($_POST["pswd"])) {
		if ($_POST["pswd"] == $_POST["pswd2"]) {
			$password = password_hash($_POST["pswd"], PASSWORD_BCRYPT); $userid = 0;
		} else $message = "Passwords don't match.";
	} else {
		$password = ""; $userid = 0;
	}

	$filename = ""; $chars = "qwertyuiopasdfghjklzxcvbnm";
	for ($i = 0; $i < 9; $i++)
		$filename .= $chars[random_int(0, strlen($chars)-1)];
	$filename = "$filename." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

	if (empty($message))
	{
		if (move_uploaded_file($_FILES['file']['tmp_name'], "storage/uploads/$filename"))
		{
			$sql = "INSERT INTO files (user_id, filename, password) VALUES (?, ?, ?)";
			$stmt = $conn->prepare($sql);
			try {
				$stmt->execute([$userid, $filename, $password]);
			} catch (Exception $e) {
				$message = $e->getMessage();
			}
		}
	}
	if ($message == "")
		$message = "Link to your file is
			<a href=\"/file/$filename\">taamminen.ru/file/$filename</a>.";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1>Upload a file</h1>
			<?php if ($message != ""): ?>
				<p><?= $message ?></p>
			<?php endif; ?>
	    <form action="/upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" /><br />
        <?php if (!$loggedin): ?>
					<input type="password" placeholder="password for delete (not required)" name="pswd" /><br />
					<input type="password" placeholder="confirm password" name="pswd2" /><br />
				<?php endif; ?>
				<input type="submit" value="Submit" />
	    </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
