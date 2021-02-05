<?php

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (Funcs::checkLoginState($conn)) {
		$userid = $_SESSION["user_id"];
		$password = "";
	} else if (!empty($_POST["pswd"])) {
		if ($_POST["pswd"] == $_POST["pswd2"]) {
			$password = password_hash($_POST["pswd"], PASSWORD_BCRYPT); $userid = 0;
		} else $message = "Passwords don't match.";
	} else {
		$password = ""; $userid = 0;
	}

	if (!Funcs::checkCSRF($csrf, $_POST['csrf'])) {
		$message = "CSRF check failed.";
		echo json_encode(["message" => $message]);
		exit;
	}

	if (empty($message)) {
		if (isset($_FILES['file'])) {
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			if (strlen($ext) > 5) $ext = substr($ext, 0, 4);
			$filename = Funcs::generateToken(9) . ".$ext";
			while (!Funcs::checkFilename($conn, $filename))
			$filename = Funcs::generateToken(9) . ".$ext";
			if (move_uploaded_file($_FILES['file']['tmp_name'], "storage/uploads/$filename")) {
				$sql = "INSERT INTO files (user_id, filename, password) VALUES (?, ?, ?)";
				$stmt = $conn->prepare($sql);
				try {
					$stmt->execute([$userid, $filename, $password]);
					$message = "Link to your file is
						<a href=\"/file/$filename\">taamminen.ru/file/$filename</a>.";
				} catch (Exception $e) {
					$message = $e->getMessage();
				}
			}
		} else $message = "File is too big or there's no file.";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
    <main>
			<h1>Upload a file <a href="/">(home)</a></h1>
			<?php if ($message != ""): ?>
				<p><?= $message ?></p>
			<?php endif; ?>
	    <form action="/upload" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" /><br />
        <?php if (!Funcs::checkLoginState($conn)): ?>
					<input type="password" placeholder="password for delete (not required)" name="pswd" /><br />
					<input type="password" placeholder="confirm password" name="pswd2" /><br />
				<?php endif; ?>
				<input type="hidden" name="csrf" value="<?= $csrf ?>" />
				<input type="submit" value="Submit" />
	    </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
