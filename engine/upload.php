<?php

include "database.php";

function checkfilename($filename, $conn) {
	$sql = "SELECT id FROM `files` WHERE filename = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array($filename));
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	if (count($row) > 0)
		return false;
	else return true;
}

function randomstring($length=9) {
	$string = ""; $chars = "qwertyuiopasdfghjklzxcvbnm";
	for ($i = 0; $i < $length; $i++)
		$string .= $chars[random_int(0, strlen($chars)-1)];
	return $string;
}

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

	$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$filename = randomstring() . ".$ext";
	while (!checkfilename($filename, $conn)) $filename = randomstring() . ".$ext";

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
			<h1>Upload a file <a href="/">(home)</a></h1>
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
