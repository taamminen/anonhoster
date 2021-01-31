<?php



?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
  <link rel="stylesheet" type="text/css" href="/static/style.css" />
</head>
<body>
    <main>
			<h1>Register</h1>
	    <form id="register-form" action="/upload" method="POST">
        <input type="text" placeholder="Name of the file" name="name" value="<?= $file->name ?>" /><br />
        <input type="text" placeholder="Yout @username" name="username" value="<?= $user->username ?>" /><br />
        <i>Your avatar</i> <input type="file" name="avatar" accept=".jpg,.png" /><br />
        <input type="password" placeholder="Your current password" name="password" />
		    <input type="submit" value="Submit" />
	    </form>
    </main>
    <script src="/static/jquery-3.5.1.min.js"></script>
    <script src="/static/script.js"></script>
</body>
</html>
